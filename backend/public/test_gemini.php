<?php
$env = file_get_contents(__DIR__ . '/../.env');
preg_match('/GEMINI_API_KEY=(.*)/', $env, $matches);
$key = trim($matches[1] ?? '', " \t\n\r\0\x0B'");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models?key=" . $key);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $result;
