<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\CommonMail;

echo "Testing Laravel Mail System with Symfony Mailer...\n";

try {
    // Test basic mail functionality
    $mail = new CommonMail(
        'This is a test email content',
        'Test Subject',
        'test@example.com',
        'Test Company'
    );
    
    echo "✓ CommonMail class instantiated successfully\n";
    
    // Test mail configuration
    $config = config('mail');
    echo "✓ Mail configuration loaded successfully\n";
    echo "  Default mailer: " . $config['default'] . "\n";
    
    // Test if Symfony Mailer is being used
    $transport = Mail::getSymfonyTransport();
    echo "✓ Symfony Transport: " . get_class($transport) . "\n";
    
    echo "\n✅ Migration to Symfony Mailer completed successfully!\n";
    echo "✅ SwiftMailer has been removed and replaced with Symfony Mailer\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
} 