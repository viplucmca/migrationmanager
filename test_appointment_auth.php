<?php

// Simple test script to debug appointment API authentication
echo "=== Appointment API Authentication Debug ===\n\n";

// Check if we can load the service directly
try {
    // Include the service file directly
    require_once 'app/Services/AppointmentApiService.php';
    
    // Create a simple test class
    class SimpleAppointmentTest {
        public function testConfig() {
            echo "1. Testing configuration...\n";
            
            // Check if .env file exists
            $envFile = '.env';
            if (file_exists($envFile)) {
                echo "   ✓ .env file found\n";
                
                // Read .env file
                $envContent = file_get_contents($envFile);
                $lines = explode("\n", $envContent);
                
                $baseUrl = null;
                $serviceToken = null;
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (strpos($line, 'APPOINTMENT_API_URL=') === 0) {
                        $baseUrl = substr($line, strlen('APPOINTMENT_API_URL='));
                        echo "   ✓ APPOINTMENT_API_URL found: " . $baseUrl . "\n";
                    }
                    if (strpos($line, 'APPOINTMENT_API_SERVICE_TOKEN=') === 0) {
                        $serviceToken = substr($line, strlen('APPOINTMENT_API_SERVICE_TOKEN='));
                        echo "   ✓ APPOINTMENT_API_SERVICE_TOKEN found: " . str_repeat('*', strlen($serviceToken)) . "\n";
                    }
                }
                
                if (!$baseUrl) {
                    echo "   ✗ APPOINTMENT_API_URL not found in .env\n";
                }
                if (!$serviceToken) {
                    echo "   ✗ APPOINTMENT_API_SERVICE_TOKEN not found in .env\n";
                }
                
                return [$baseUrl, $serviceToken];
            } else {
                echo "   ✗ .env file not found\n";
                return [null, null];
            }
        }
        
        public function testServiceCreation($baseUrl, $serviceToken) {
            echo "\n2. Testing service creation...\n";
            
            try {
                $service = new \App\Services\AppointmentApiService($baseUrl, $serviceToken);
                echo "   ✓ Service created successfully\n";
                return $service;
            } catch (Exception $e) {
                echo "   ✗ Failed to create service: " . $e->getMessage() . "\n";
                return null;
            }
        }
        
        public function testAuthentication($service) {
            echo "\n3. Testing authentication...\n";
            
            if (!$service) {
                echo "   ✗ Cannot test authentication - service is null\n";
                return false;
            }
            
            try {
                $result = $service->authenticate();
                echo "   ✓ Authentication successful\n";
                return true;
            } catch (Exception $e) {
                echo "   ✗ Authentication failed: " . $e->getMessage() . "\n";
                return false;
            }
        }
    }
    
    // Run the tests
    $test = new SimpleAppointmentTest();
    
    // Test 1: Check configuration
    list($baseUrl, $serviceToken) = $test->testConfig();
    
    // Test 2: Create service
    $service = $test->testServiceCreation($baseUrl, $serviceToken);
    
    // Test 3: Test authentication
    $authResult = $test->testAuthentication($service);
    
    echo "\n=== Test Summary ===\n";
    if ($authResult) {
        echo "✓ All tests passed! Authentication is working.\n";
    } else {
        echo "✗ Authentication failed. Please check your configuration.\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} 