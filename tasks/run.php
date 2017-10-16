<?php
use RedBeanPHP\R;

require '../vendor/autoload.php';
require 'lib/Runner.php';

// init f3 instance
$f3 = \Base::instance();

// load app config
$f3->config('../app/config.ini');

// connect to redbean
if (!R::testConnection()) {

    // get framework
    $f3 = \Base::instance();

    $db = $f3->get('db');

    R::addDatabase(
        'connection',
        'mysql:host='.$db['host'].';dbname='.$db['name'],
        $db['username'],
        $db['password']
    );

    R::selectDatabase('connection');
    R::freeze($db['freeze']);
    R::debug($db['debug'], 2);
}

// load local plinker server endpoint
$server = R::load('servers', 1);

// convert its config into an array
$config = json_decode($server->config, true);

// init task runner
$task = new Tasks\Runner($config);
$task->climate = new League\CLImate\CLImate;

$task->daemon('Daemon', [
    'sleep_time' => $config['sleep_time']
]);
