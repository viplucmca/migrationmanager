<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing AppointmentApiService Authentication\n";
echo "============================================\n\n";

// Check configuration
echo "Configuration Check:\n";
echo "Base URL: " . config('services.appointment_api.url') . "\n";
echo "Service Token: " . (config('services.appointment_api.service_token') ? 'SET (' . strlen(config('services.appointment_api.service_token')) . ' chars)' : 'NOT SET') . "\n\n";

// Test the service
try {
    $service = new \App\Services\AppointmentApiService();
    echo "Service created successfully\n";
    
    echo "Attempting authentication...\n";
    $result = $service->authenticate();
    echo "Authentication result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\nDone.\n"; 