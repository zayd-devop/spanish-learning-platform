<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Intercept OPTIONS requests early to guarantee CORS preflight succeeds
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, PATCH');
    header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization, Accept, X-Requested-With');
    header('Access-Control-Max-Age: 86400');
    http_response_code(204);
    exit;
}

// Vercel Serverless Fixes:
// Overwrite Laravel storage paths to /tmp so it doesn't crash on Vercel's read-only file system
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
    $_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
    $_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0777, true);
    }
}

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
