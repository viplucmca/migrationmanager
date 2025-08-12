# Service Account Token Generation

This feature automatically generates service account tokens in the background when an admin logs in to the system.

## Overview

When an admin successfully logs in, the system automatically dispatches a background job to generate a service account token by making an API call to `https://migrationmanager.bansalcrm.com/api/service-account/generate-token`.

## Files Created/Modified

### New Files:
1. `app/Jobs/GenerateServiceAccountToken.php` - Background job for token generation
2. `app/Services/ServiceAccountTokenService.php` - Service class for token operations
3. `app/Console/Commands/ProcessServiceAccountTokens.php` - Console command for manual token generation
4. `database/migrations/2025_08_01_181242_add_service_token_to_admins_table.php` - Migration for storing tokens

### Modified Files:
1. `app/Http/Controllers/Auth/AdminLoginController.php` - Added token generation on login
2. `app/Admin.php` - Added new fillable fields
3. `app/Console/Kernel.php` - Registered new command

## How It Works

### Automatic Token Generation
1. Admin logs in successfully
2. System validates reCAPTCHA
3. If validation passes, a background job is dispatched
4. Job makes API call to generate token
5. Token is stored in database (optional)
6. All operations are logged

### Manual Token Generation
You can manually generate tokens using the console command:

```bash
# Generate token for all active admins (background)
php artisan service-account:generate-token

# Generate token for specific admin (background)
php artisan service-account:generate-token 1

# Generate token synchronously (immediate)
php artisan service-account:generate-token 1 --sync

# Generate tokens for all admins synchronously
php artisan service-account:generate-token --sync
```

## Database Schema

The `admins` table now includes:
- `service_token` (TEXT, nullable) - Stores the generated token
- `token_generated_at` (TIMESTAMP, nullable) - When the token was generated

## Configuration

### Queue Configuration
Make sure your queue is properly configured in `config/queue.php`. The default is 'sync', but for production, you should use 'database' or 'redis'.

To run the queue worker:
```bash
php artisan queue:work
```

### Environment Variables
No additional environment variables are required, but you can customize the service name and description in the service class.

## API Endpoint

The system calls this endpoint:
```
POST https://migrationmanager.bansalcrm.com/api/service-account/generate-token
```

With payload:
```json
{
    "service_name": "Bansal Immigration CRM",
    "description": "Service account token for admin authentication",
    "admin_email": "admin@example.com",
    "admin_password": "admin_password"
}
```

## Error Handling

- All errors are logged to Laravel's log system
- Failed jobs are handled gracefully
- Login process is not interrupted if token generation fails
- Retry logic is built into the job system

## Testing

1. **Test Login Flow**: Login as admin and check logs for token generation
2. **Test Manual Command**: Use the console command to test token generation
3. **Test Queue**: Ensure queue worker is running for background jobs

## Logs

Check the following log entries:
- `Service account token generation job dispatched`
- `Service account token generated successfully`
- `Failed to generate service account token`
- `Exception occurred while generating service account token`

## Security Notes

- Tokens are stored in the database (optional)
- Passwords are sent to the external API (ensure HTTPS)
- All operations are logged for audit purposes
- Background jobs prevent blocking the login process

## Troubleshooting

1. **Token not generating**: Check if queue worker is running
2. **API errors**: Check network connectivity and API endpoint
3. **Database errors**: Ensure migration has been run
4. **Log errors**: Check Laravel logs for detailed error messages 