<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Appointment API Authentication Debug ===\n\n";

// 1. Check if .env file exists
$envFile = '.env';
if (file_exists($envFile)) {
    echo "✓ .env file found\n";
    
    // Read .env file
    $envContent = file_get_contents($envFile);
    $envLines = explode("\n", $envContent);
    
    $hasApiUrl = false;
    $hasServiceToken = false;
    
    foreach ($envLines as $line) {
        $line = trim($line);
        if (strpos($line, 'APPOINTMENT_API_URL=') === 0) {
            $hasApiUrl = true;
            $url = substr($line, strlen('APPOINTMENT_API_URL='));
            echo "  - APPOINTMENT_API_URL: " . ($url ? $url : 'NOT SET') . "\n";
        }
        if (strpos($line, 'APPOINTMENT_API_SERVICE_TOKEN=') === 0) {
            $hasServiceToken = true;
            $token = substr($line, strlen('APPOINTMENT_API_SERVICE_TOKEN='));
            echo "  - APPOINTMENT_API_SERVICE_TOKEN: " . ($token ? 'SET (' . strlen($token) . ' chars)' : 'NOT SET') . "\n";
        }
    }
    
    if (!$hasApiUrl) {
        echo "  ✗ APPOINTMENT_API_URL not found in .env\n";
    }
    if (!$hasServiceToken) {
        echo "  ✗ APPOINTMENT_API_SERVICE_TOKEN not found in .env\n";
    }
} else {
    echo "✗ .env file not found\n";
    echo "  Please create a .env file with the following variables:\n";
    echo "  APPOINTMENT_API_URL=https://your-api-domain.com/api\n";
    echo "  APPOINTMENT_API_SERVICE_TOKEN=your-service-token-here\n\n";
    exit(1);
}

echo "\n";

// 2. Check Laravel configuration
echo "2. Laravel Configuration Check:\n";
try {
    $configUrl = config('services.appointment_api.url');
    $configToken = config('services.appointment_api.service_token');
    
    echo "  - Config URL: " . ($configUrl ?: 'NOT SET') . "\n";
    echo "  - Config Token: " . ($configToken ? 'SET (' . strlen($configToken) . ' chars)' : 'NOT SET') . "\n";
    
    if (!$configUrl || !$configToken) {
        echo "  ✗ Configuration incomplete. Please check your .env file.\n";
        exit(1);
    }
    
} catch (Exception $e) {
    echo "  ✗ Error reading configuration: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n";

// 3. Test service creation
echo "3. Service Creation Test:\n";
try {
    $service = new \App\Services\AppointmentApiService();
    echo "  ✓ Service created successfully\n";
    
    // Check service properties
    $reflection = new ReflectionClass($service);
    $baseUrlProp = $reflection->getProperty('baseUrl');
    $baseUrlProp->setAccessible(true);
    $serviceTokenProp = $reflection->getProperty('serviceToken');
    $serviceTokenProp->setAccessible(true);
    
    $serviceUrl = $baseUrlProp->getValue($service);
    $serviceToken = $serviceTokenProp->getValue($service);
    
    echo "  - Service URL: " . $serviceUrl . "\n";
    echo "  - Service Token: " . ($serviceToken ? 'SET (' . strlen($serviceToken) . ' chars)' : 'NOT SET') . "\n";
    
} catch (Exception $e) {
    echo "  ✗ Service creation failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n";

// 4. Test network connectivity
echo "4. Network Connectivity Test:\n";
try {
    $testUrl = rtrim($configUrl, '/') . '/service-account/authenticate';
    echo "  - Testing connection to: " . $testUrl . "\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "  ✗ Connection failed: " . $error . "\n";
    } else {
        echo "  ✓ Connection successful (HTTP " . $httpCode . ")\n";
    }
    
} catch (Exception $e) {
    echo "  ✗ Network test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// 5. Test authentication
echo "5. Authentication Test:\n";
try {
    echo "  - Attempting authentication...\n";
    $result = $service->authenticate();
    
    if ($result) {
        echo "  ✓ Authentication successful!\n";
        
        // Check if token was set
        $tokenProp = $reflection->getProperty('token');
        $tokenProp->setAccessible(true);
        $token = $tokenProp->getValue($service);
        
        if ($token) {
            echo "  - Token received: " . substr($token, 0, 20) . "...\n";
        }
        
    } else {
        echo "  ✗ Authentication failed (returned false)\n";
    }
    
} catch (Exception $e) {
    echo "  ✗ Authentication failed: " . $e->getMessage() . "\n";
    echo "  - File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n";

// 6. Check cache
echo "6. Cache Check:\n";
try {
    $cachedToken = \Illuminate\Support\Facades\Cache::get('appointment_api_token');
    if ($cachedToken) {
        echo "  ✓ Cached token found: " . substr($cachedToken, 0, 20) . "...\n";
    } else {
        echo "  - No cached token found\n";
    }
} catch (Exception $e) {
    echo "  ✗ Cache check failed: " . $e->getMessage() . "\n";
}

echo "\n=== Debug Complete ===\n"; 