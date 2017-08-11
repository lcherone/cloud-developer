<?php
require '../vendor/autoload.php';
require 'lib/Runner.php';

// init f3 instance
$f3 = \Base::instance();

// load app config
$f3->config('../app/config.ini');

$config = [
    // plinker configuration
    'plinker' => [
        // tracker or control system which reports should be sent to
        'tracker' => 'http://c9-cloud.free.lxd.systems',
        
        // peer should point to this instance
        'peer' => 'http://c9-cloud.free.lxd.systems',

        // network keys
        'public_key'  => 'f6e894b79c8a8368b0f6d94c6b322e0f6881bab7da964abbed85525386e9cb37',
        
        // should be the same across all servers
        'private_key' => 'd80fcf7b7a4ebd98574a7e73fc1801cf201e6c95aa5a0b8f8f5e6eafc155ef1d',

        'enabled' => true,
        'encrypted' => true
    ],

    // database connection
    // default: sqlite:'.__DIR__.'/database.db
    'database' => $f3->get('db'),

    // displays output to consoles
    'debug' => true,

    // daemon sleep time
    'sleep_time' => 1
];

$task = new Tasks\Runner($config);
$task->climate = new League\CLImate\CLImate;

$task->daemon('Daemon', [
    'sleep_time' => $config['sleep_time']
]);
