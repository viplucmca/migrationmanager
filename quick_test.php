<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Quick Configuration and Connectivity Test\n";
echo "========================================\n\n";

// Check configuration
$apiUrl = config('services.appointment_api.url');
$serviceToken = config('services.appointment_api.service_token');

echo "Current Configuration:\n";
echo "- API URL: " . ($apiUrl ?: 'NOT SET') . "\n";
echo "- Service Token: " . ($serviceToken ? 'SET (' . strlen($serviceToken) . ' chars)' : 'NOT SET') . "\n\n";

if (!$apiUrl) {
    echo "❌ API URL is not configured. Please add APPOINTMENT_API_URL to your .env file.\n";
    exit(1);
}

// Test connectivity
echo "Testing connectivity to: $apiUrl\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'BansalImmigration/1.0');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($error) {
    echo "❌ Connection failed: $error\n\n";
    echo "Possible solutions:\n";
    echo "1. Check your internet connection\n";
    echo "2. Verify the API URL is correct\n";
    echo "3. Check if the API server is running\n";
    echo "4. Try using HTTP instead of HTTPS if it's a development server\n";
    echo "5. Check firewall settings\n";
} else {
    echo "✅ Connection successful (HTTP $httpCode)\n";
    echo "- Response time: " . round($info['total_time'] * 1000, 2) . "ms\n";
    
    if ($httpCode == 404) {
        echo "⚠️  Server responded with 404 - endpoint might not exist\n";
    } elseif ($httpCode >= 500) {
        echo "⚠️  Server error - API might be down\n";
    }
}

echo "\n"; 