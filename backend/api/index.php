<?php

// 1. Vercel Serverless environments only allow writing to /tmp.
// We must override Laravel's default storage paths to prevent permission denied errors (500s).
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

// Ensure the temporary views directory exists
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// 2. Vercel routes all traffic through api/index.php.
// We need to trick Laravel into thinking the request hit public/index.php,
// otherwise Laravel's router will get confused and return 404s.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

// 3. Forward the request to Laravel's actual entry point
require __DIR__ . '/../public/index.php';
