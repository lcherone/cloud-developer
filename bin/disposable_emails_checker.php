<?php
/**
 * This PHP script allows for fails, keeps all records and does not hammer DNS server.
 * It creates a working file, then pops out what its done into either _up/_down files.
 * 
 * Should be run in CLI, then your see output on status whilst it works.
 *  Up:---0815.ru
 *  Down:-0815.ru0clickemail.com
 *  Down:-0815.ry
 *  Up:---0815.su
 *  Down:-0845.ru
 *  Up:---0clickemail.com
 *  Up:---0-mail.com
 *  Up:---0wnd.net
 *  Up:---0wnd.org
 *  Up:---10mail.com
 *  Up:---10mail.org
 *  Up:---10minut.com.pl
 *  Up:---10minute-email.com
 */

set_time_limit(0);
ignore_user_abort(true);
putenv('RES_OPTIONS=retrans:1 retry:1 timeout:1 attempts:1');

/**
 * Working files, change to suit
 */
$files = [
    'original' => 'disposable_emails.txt',
    'working'  => 'disposable_emails_working.txt',
    'up'       => 'disposable_emails_dns_up.txt',
    'down'     => 'disposable_emails_dns_down.txt'
];

// filter
$filter = function($key) use ($files) {
    return array_unique(array_filter(array_map('trim', file($files[$key]))));
};

// create working files
if (!file_exists($files['working'])) {
    if (!file_exists($files['original'])) {
        die('Error: Called from wrong directory or '.$files['original'].' does not exist!');
    }
    copy($files['original'], $files['working']);
}

// get array and remove dupes
$domains = $filter('working');

// sort
natsort($domains);

// process
foreach ($domains as $key => $domain) {
    
    // MX is up
    if (checkdnsrr($domain, 'MX') !== false) {
        echo 'Up:---'.$domain.PHP_EOL;
        file_put_contents($files['up'], $domain.PHP_EOL, FILE_APPEND);
    }
    
    // MX is down
    else {
        echo 'Down:-'.$domain.PHP_EOL;
        file_put_contents($files['down'], $domain.PHP_EOL, FILE_APPEND);
    }
  
    // unset the working domain and update file
    unset($domains[$key]);
    file_put_contents($files['working'], implode(PHP_EOL, $domains));
  
    // wait 1/2 a sec
    usleep(500000);
}

// tidy/sort lists
if (empty($domains)) {
    // tidy up
    $up = $filter('up');
    natsort($up);
    file_put_contents($files['up'], implode(PHP_EOL, $up));
    
    // tidy down
    $down = $filter('down');
    natsort($down);
    file_put_contents($files['down'], implode(PHP_EOL, $down));
    
    // fin
    $original = $filter('original');
    natsort($original);
    file_put_contents($files['original'], implode(PHP_EOL, $original));
    
    die(count($original).' domains checked, up: '.count($up).' down: '.count($down).PHP_EOL);
} else {
    die('Working list not empty, check it.'.PHP_EOL);
}
