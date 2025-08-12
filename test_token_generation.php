<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ServiceAccountTokenService;
use App\Admin;

try {
    echo "Testing Service Account Token Generation...\n";
    
    // Get the first admin user
    $admin = Admin::first();
    
    if (!$admin) {
        echo "No admin user found in database.\n";
        exit(1);
    }
    
    echo "Found admin: {$admin->email}\n";
    
    // Test the token generation service
    $tokenService = new ServiceAccountTokenService();
    
    echo "Generating token synchronously...\n";
    $result = $tokenService->generateTokenSync($admin, 'Test Service', 'Test Description', 'admin123');
    
    if ($result) {
        echo "Token generated successfully!\n";
        echo "Token: " . ($result['token'] ?? 'N/A') . "\n";
        echo "Service: " . ($result['service_name'] ?? 'N/A') . "\n";
        echo "Admin: " . ($result['admin_email'] ?? 'N/A') . "\n";
    } else {
        echo "Token generation failed!\n";
    }
    
    echo "Test completed.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} 