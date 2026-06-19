<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
try {
    $kernel->call('migrate', ['--force' => true]);
    echo "Migration output:\n";
    echo $kernel->output();
} catch (\Exception $e) {
    echo "Exception:\n";
    echo $e->getMessage();
}
