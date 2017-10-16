<?php
// set timezone
date_default_timezone_set('UTC');

// start session
session_start();

chdir('../');

// composers autoloader
require_once('vendor/autoload.php');

// init f3 instance
$f3 = \Base::instance();

// load config
$f3->config('app/config.ini');
$f3->config('app/routes.ini');

// run app
$f3->run();
