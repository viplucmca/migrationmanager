<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Production API Integration ===\n\n";

try {
    // Create service with production URL
    $service = new \App\Services\AppointmentApiService();
    
    echo "✓ Service created with production configuration\n";
    
    // Check configuration
    $configUrl = config('services.appointment_api.url');
    $configToken = config('services.appointment_api.service_token');
    
    echo "Configuration:\n";
    echo "  - API URL: " . $configUrl . "\n";
    echo "  - Service Token: " . ($configToken ? 'SET (' . strlen($configToken) . ' chars)' : 'NOT SET') . "\n\n";
    
    if (!$configToken) {
        echo "✗ Service token not configured. Please check your .env file.\n";
        exit(1);
    }
    
    // Test authentication
    echo "Testing authentication with production API...\n";
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
        
        // Test getting appointments
        echo "\nTesting getAppointments...\n";
        try {
            $appointments = $service->getAppointments(['limit' => 5]);
            echo "✓ getAppointments successful\n";
            if (isset($appointments['data'])) {
                echo "  - Found " . count($appointments['data']) . " appointments\n";
            }
        } catch (Exception $e) {
            echo "⚠️  getAppointments: " . $e->getMessage() . "\n";
        }
        
        // Test getting statistics
        echo "\nTesting getStatistics...\n";
        try {
            $stats = $service->getStatistics();
            echo "✓ getStatistics successful\n";
            if (isset($stats['data'])) {
                echo "  - Statistics retrieved successfully\n";
            }
        } catch (Exception $e) {
            echo "⚠️  getStatistics: " . $e->getMessage() . "\n";
        }
        
        // Test cache functionality
        echo "\nTesting cache functionality...\n";
        $cachedToken = \Illuminate\Support\Facades\Cache::get('appointment_api_token');
        if ($cachedToken) {
            echo "✓ Token is cached\n";
        }
        
    } else {
        echo "✗ Authentication failed\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n"; 