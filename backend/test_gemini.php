<?php
$key = getenv('GEMINI_API_KEY');
if (!$key) {
    // Read from .env
    $env = file_get_contents(__DIR__ . '/.env');
    preg_match('/GEMINI_API_KEY=(.*)/', $env, $matches);
    $key = trim($matches[1] ?? '');
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models?key=" . $key);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

$models = json_decode($result, true);
if (isset($models['models'])) {
    foreach ($models['models'] as $m) {
        if (strpos($m['name'], 'gemini-1.5') !== false) {
            echo $m['name'] . "\n";
        }
    }
} else {
    echo "Error: " . $result;
}
