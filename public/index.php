<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Absolute path to the Laravel application root on Truehost.
// The web root (public_html/) is separate from the app root,
// so relative paths like __DIR__.'/../' resolve to /home/kenyanba/
$appBase = file_exists(__DIR__ . '/../vendor/autoload.php')
    ? dirname(__DIR__)
    : '/home/kenyanba/repositories/Baddies';
define('LARAVEL_APP_BASE', $appBase);

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = LARAVEL_APP_BASE . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require LARAVEL_APP_BASE . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once LARAVEL_APP_BASE . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
