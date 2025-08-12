<?php

require_once 'vendor/autoload.php';

use App\Services\AppointmentApiService;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Fixed Authentication ===\n\n";

try {
    $apiService = new AppointmentApiService();
    
    echo "Base URL: " . $apiService->baseUrl . "\n";
    echo "Service Token Length: " . strlen($apiService->serviceToken) . "\n\n";
    
    echo "Attempting authentication...\n";
    $result = $apiService->authenticate();
    
    if ($result) {
        echo "✅ Authentication SUCCESSFUL!\n";
        echo "Token Length: " . strlen($apiService->token ?? '') . "\n";
        
        // Test getting appointments
        echo "\nTesting getAppointments...\n";
        try {
            $appointments = $apiService->getAppointments();
            echo "✅ getAppointments SUCCESSFUL!\n";
            echo "Response keys: " . implode(', ', array_keys($appointments)) . "\n";
        } catch (Exception $e) {
            echo "❌ getAppointments failed: " . $e->getMessage() . "\n";
        }
        
        // Test getting statistics
        echo "\nTesting getStatistics...\n";
        try {
            $stats = $apiService->getStatistics();
            echo "✅ getStatistics SUCCESSFUL!\n";
            echo "Response keys: " . implode(', ', array_keys($stats)) . "\n";
        } catch (Exception $e) {
            echo "❌ getStatistics failed: " . $e->getMessage() . "\n";
        }
        
    } else {
        echo "❌ Authentication FAILED\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n"; 