<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Specific API Endpoint ===\n\n";

$baseUrl = 'https://www.bansalimmigration.com.au/api';
$endpoint = '/service-account/authenticate';
$fullUrl = $baseUrl . $endpoint;

echo "Testing URL: " . $fullUrl . "\n\n";

// Test different HTTP methods
$methods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];

foreach ($methods as $method) {
    echo "Testing " . $method . " method...\n";
    
    try {
        $httpClient = Http::timeout(10)
            ->withOptions([
                'verify' => false,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ]
            ])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'BansalImmigration/1.0'
            ]);

        switch ($method) {
            case 'GET':
                $response = $httpClient->get($fullUrl);
                break;
            case 'POST':
                $response = $httpClient->post($fullUrl, ['test' => 'data']);
                break;
            case 'PUT':
                $response = $httpClient->put($fullUrl, ['test' => 'data']);
                break;
            case 'DELETE':
                $response = $httpClient->delete($fullUrl);
                break;
            case 'OPTIONS':
                $response = $httpClient->send('OPTIONS', $fullUrl);
                break;
        }

        echo "  Status: " . $response->status() . "\n";
        echo "  Allowed Methods: " . ($response->header('Allow') ?: 'Not specified') . "\n";
        echo "  Content-Type: " . ($response->header('Content-Type') ?: 'Not specified') . "\n";
        
        if ($response->status() === 405) {
            echo "  Body: " . substr($response->body(), 0, 200) . "...\n";
        }
        
    } catch (Exception $e) {
        echo "  Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "=== Test Complete ===\n"; 