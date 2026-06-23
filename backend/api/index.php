<?php
// Vercel Serverless Fixes
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// CRITICAL FIX: If Vercel strips /api from the URL because this file is inside the /api folder, we add it back!
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/api') !== 0) {
    $_SERVER['REQUEST_URI'] = '/api' . $_SERVER['REQUEST_URI'];
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

require __DIR__ . '/../public/index.php';
