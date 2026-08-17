<?php
require_once __DIR__ . '/config/gemini.php';

$ch = curl_init("https://api.groq.com/openai/v1/models");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . GEMINI_API_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);
echo "Response: " . $response . "\n";
curl_close($ch);
?>
