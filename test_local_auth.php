<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Local Authentication ===\n\n";

try {
    // Create service with local URL
    $service = new \App\Services\AppointmentApiService('http://localhost/api', 'test_token_123');
    
    echo "✓ Service created with local URL\n";
    
    // Test authentication
    echo "Testing authentication...\n";
    $result = $service->authenticate();
    
    if ($result) {
        echo "✓ Authentication successful!\n";
        
        // Check if token was set
        $reflection = new ReflectionClass($service);
        $tokenProp = $reflection->getProperty('token');
        $tokenProp->setAccessible(true);
        $token = $tokenProp->getValue($service);
        
        if ($token) {
            echo "✓ Token received: " . substr($token, 0, 30) . "...\n";
        }
        
        // Test cache
        $cachedToken = \Illuminate\Support\Facades\Cache::get('appointment_api_token');
        if ($cachedToken) {
            echo "✓ Token cached successfully\n";
        }
        
    } else {
        echo "✗ Authentication failed\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n"; 