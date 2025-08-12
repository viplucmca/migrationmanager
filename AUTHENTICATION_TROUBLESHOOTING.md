# Appointment API Authentication Troubleshooting Guide

## Common Issues and Solutions

### 1. Missing .env File
**Problem**: The `.env` file is missing or doesn't contain the required variables.

**Solution**: Create a `.env` file in your project root with the following variables:

```env
APPOINTMENT_API_URL=https://migrationmanager.bansalcrm.com/api
APPOINTMENT_API_SERVICE_TOKEN=your-actual-service-token
APPOINTMENT_API_TIMEOUT=30
```

### 2. Configuration Not Loaded
**Problem**: Laravel is not reading the environment variables.

**Solution**: 
- Clear Laravel's configuration cache: `php artisan config:clear`
- Clear application cache: `php artisan cache:clear`
- Restart your web server

### 3. Invalid Service Token
**Problem**: The service token is incorrect or expired.

**Solution**:
- Verify the token with your API provider
- Check if the token has expired
- Ensure there are no extra spaces or characters in the token

### 4. Network Connectivity Issues
**Problem**: Cannot reach the API server.

**Solution**:
- Check your internet connection
- Verify the API URL is correct
- Check if the API server is running
- Test with curl: `curl -I https://migrationmanager.bansalcrm.com/api/service-account/authenticate`

### 5. API Endpoint Issues
**Problem**: The authentication endpoint is incorrect or not responding.

**Solution**:
- Verify the endpoint URL: `/service-account/authenticate`
- Check if the API has changed its endpoints
- Contact the API provider for documentation

## Debugging Steps

### Step 1: Run the Debug Script
```bash
php debug_auth.php
```

This script will:
- Check if `.env` file exists
- Verify configuration variables
- Test network connectivity
- Attempt authentication
- Show detailed error messages

### Step 2: Check Laravel Logs
Look for authentication errors in:
```
storage/logs/laravel.log
```

### Step 3: Test Configuration
```php
// In Laravel Tinker or a test script
echo config('services.appointment_api.url');
echo config('services.appointment_api.service_token');
```

### Step 4: Manual API Test
Test the API endpoint directly:
```bash
curl -X POST https://migrationmanager.bansalcrm.com/api/service-account/authenticate \
  -H "Content-Type: application/json" \
  -d '{"service_token":"your-token-here"}'
```

## Error Messages and Meanings

| Error Message | Meaning | Solution |
|---------------|---------|----------|
| "Service token is not configured" | Missing APPOINTMENT_API_SERVICE_TOKEN in .env | Add the token to .env file |
| "Base URL is not configured" | Missing APPOINTMENT_API_URL in .env | Add the URL to .env file |
| "Invalid base URL format" | URL is malformed | Check URL format in .env |
| "Connection failed" | Network connectivity issue | Check internet connection and API URL |
| "Authentication failed: Invalid service token (401)" | Token is invalid | Verify token with API provider |
| "Authentication endpoint not found (404)" | Wrong API URL | Check API URL and endpoint |
| "Server error (500)" | API server error | Contact API provider |

## Testing the Authentication

### Quick Test
```php
<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $service = new \App\Services\AppointmentApiService();
    $result = $service->authenticate();
    echo "Authentication: " . ($result ? "SUCCESS" : "FAILED") . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Clear Cache
If you're having issues with cached tokens:
```php
$service = new \App\Services\AppointmentApiService();
$service->clearCache();
```

## Contact Information

If you continue to have issues:
1. Check the API documentation
2. Contact your API provider
3. Review the Laravel logs for detailed error information
4. Use the debug script to identify the specific issue 