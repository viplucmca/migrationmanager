<?php

echo "=== API URL Test ===\n\n";

// Test different possible API URLs
$possibleUrls = [
    'https://migrationmanager.bansalcrm.com/api',
    'https://migrationmanager.bansalcrm.com',
    'http://migrationmanager.bansalcrm.com/api',
    'http://migrationmanager.bansalcrm.com',
    'https://bansalimmigration.com.au/api',
    'https://bansalimmigration.com.au'
];

foreach ($possibleUrls as $url) {
    echo "Testing: $url\n";
    
    // Test DNS resolution
    $host = parse_url($url, PHP_URL_HOST);
    $ip = gethostbyname($host);
    
    if ($ip && $ip !== $host) {
        echo "  ✓ DNS: $host -> $ip\n";
    } else {
        echo "  ✗ DNS: Cannot resolve $host\n";
        continue;
    }
    
    // Test HTTP connectivity
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'BansalImmigration/1.0');
    curl_setopt($ch, CURLOPT_NOBODY, true);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    if ($error) {
        echo "  ✗ HTTP: $error\n";
    } else {
        echo "  ✓ HTTP: $httpCode (" . round($info['total_time'] * 1000, 2) . "ms)\n";
        
        // If this URL works, test the authentication endpoint
        $authUrl = rtrim($url, '/') . '/service-account/authenticate';
        echo "  - Testing auth endpoint: $authUrl\n";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $authUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'BansalImmigration/1.0');
        curl_setopt($ch, CURLOPT_NOBODY, true);
        
        $authResult = curl_exec($ch);
        $authHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $authError = curl_error($ch);
        curl_close($ch);
        
        if ($authError) {
            echo "    ✗ Auth endpoint: $authError\n";
        } else {
            echo "    ✓ Auth endpoint: $authHttpCode\n";
            if ($authHttpCode == 404) {
                echo "    ⚠️  Endpoint not found (404) - might need different path\n";
            } elseif ($authHttpCode == 405) {
                echo "    ⚠️  Method not allowed (405) - endpoint exists but wrong method\n";
            }
        }
    }
    
    echo "\n";
}

echo "=== Test Complete ===\n"; 