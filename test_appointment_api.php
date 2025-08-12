<?php

require_once 'vendor/autoload.php';

use App\Services\AppointmentApiService;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Appointment API Configuration Test ===\n\n";

try {
    $apiService = new AppointmentApiService();
    
    // Test configuration
    echo "1. Testing API Configuration...\n";
    $config = $apiService->testConfiguration();
    
    echo "Base URL: " . $config['base_url'] . "\n";
    echo "Service Token Exists: " . ($config['service_token_exists'] ? 'Yes' : 'No') . "\n";
    echo "Service Token Length: " . $config['service_token_length'] . "\n";
    echo "Cached Token Exists: " . ($config['cached_token_exists'] ? 'Yes' : 'No') . "\n\n";
    
    if (isset($config['health_check'])) {
        echo "Health Check Status: " . $config['health_check']['status'] . "\n";
        echo "Health Check Successful: " . ($config['health_check']['successful'] ? 'Yes' : 'No') . "\n\n";
    }
    
    if (isset($config['endpoint_tests'])) {
        echo "2. Testing Authentication Endpoints...\n";
        foreach ($config['endpoint_tests'] as $endpoint => $test) {
            echo "Endpoint: " . $endpoint . "\n";
            if (isset($test['error'])) {
                echo "  Error: " . $test['error'] . "\n";
            } else {
                echo "  Status: " . $test['status'] . "\n";
                echo "  Allowed Methods: " . ($test['allowed_methods'] ?: 'Not specified') . "\n";
                echo "  Exists: " . ($test['exists'] ? 'Yes' : 'No') . "\n";
            }
            echo "\n";
        }
    }
    
    // Try authentication
    echo "3. Testing Authentication...\n";
    try {
        $result = $apiService->authenticate();
        echo "Authentication: SUCCESS\n";
        echo "Token Length: " . strlen($apiService->token ?? '') . "\n";
    } catch (Exception $e) {
        echo "Authentication: FAILED\n";
        echo "Error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n"; 