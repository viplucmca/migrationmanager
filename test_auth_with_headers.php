<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Authentication with Different Approaches ===\n\n";

$baseUrl = 'https://www.bansalimmigration.com.au/api';
$endpoint = '/service-account/authenticate';
$fullUrl = $baseUrl . $endpoint;

echo "Testing URL: " . $fullUrl . "\n\n";

// Get the service token from config
$serviceToken = config('services.appointment_api.service_token');
echo "Service Token Length: " . strlen($serviceToken) . "\n\n";

// Test different approaches
$tests = [
    [
        'name' => 'Basic POST with service_token',
        'data' => ['service_token' => $serviceToken]
    ],
    [
        'name' => 'POST with Authorization header',
        'data' => [],
        'headers' => ['Authorization' => 'Bearer ' . $serviceToken]
    ],
    [
        'name' => 'POST with X-Service-Token header',
        'data' => [],
        'headers' => ['X-Service-Token' => $serviceToken]
    ],
    [
        'name' => 'POST with token in query',
        'data' => [],
        'url' => $fullUrl . '?service_token=' . $serviceToken
    ],
    [
        'name' => 'POST with different parameter name',
        'data' => ['token' => $serviceToken]
    ],
    [
        'name' => 'POST with api_key parameter',
        'data' => ['api_key' => $serviceToken]
    ]
];

foreach ($tests as $test) {
    echo "Test: " . $test['name'] . "\n";
    
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

        // Add custom headers if specified
        if (isset($test['headers'])) {
            foreach ($test['headers'] as $key => $value) {
                $httpClient = $httpClient->withHeaders([$key => $value]);
            }
        }

        $url = $test['url'] ?? $fullUrl;
        $response = $httpClient->post($url, $test['data']);

        echo "  Status: " . $response->status() . "\n";
        echo "  Content-Type: " . ($response->header('Content-Type') ?: 'Not specified') . "\n";
        
        if ($response->successful()) {
            echo "  SUCCESS! Response: " . substr($response->body(), 0, 200) . "...\n";
        } else {
            echo "  Error Response: " . substr($response->body(), 0, 200) . "...\n";
        }
        
    } catch (Exception $e) {
        echo "  Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

// Also test some alternative endpoints
echo "=== Testing Alternative Endpoints ===\n\n";

$alternativeEndpoints = [
    '/auth/service-account',
    '/authenticate',
    '/api/auth/service-account',
    '/api/authenticate',
    '/service-account/token',
    '/auth/token'
];

foreach ($alternativeEndpoints as $altEndpoint) {
    echo "Testing: " . $altEndpoint . "\n";
    
    try {
        $response = Http::timeout(5)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post($baseUrl . $altEndpoint, ['service_token' => $serviceToken]);

        echo "  Status: " . $response->status() . "\n";
        if ($response->status() !== 404) {
            echo "  Response: " . substr($response->body(), 0, 100) . "...\n";
        }
        
    } catch (Exception $e) {
        echo "  Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "=== Test Complete ===\n"; 