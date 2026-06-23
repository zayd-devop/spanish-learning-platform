<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Simulate Vercel environment
$_SERVER['REQUEST_URI'] = '/api/login';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
$_SERVER['REQUEST_METHOD'] = 'POST';

$request = \Illuminate\Http\Request::capture();

echo "Path Info: " . $request->getPathInfo() . "\n";
echo "Path: " . $request->path() . "\n";
echo "Method: " . $request->method() . "\n";
echo "Base URL: " . $request->getBaseUrl() . "\n";

try {
    $route = $app->make('router')->getRoutes()->match($request);
    echo "Matched Route: " . $route->uri() . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
