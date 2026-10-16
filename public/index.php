<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Absolute path to the Laravel application root on Truehost.
// The web root (public_html/) is separate from the app root,
// so relative paths like __DIR__.'/../' resolve to /home/kenyanba/
// instead of /home/kenyanba/repositories/Baddies/. We fix that here.
define('LARAVEL_APP_BASE', '/home/kenyanba/repositories/Baddies');

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
