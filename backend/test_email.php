<?php

require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Illuminate\Support\Facades\Mail;

// Test email configuration
echo "Testing email configuration...\n";
echo "MAIL_HOST: " . $_ENV['MAIL_HOST'] . "\n";
echo "MAIL_PORT: " . $_ENV['MAIL_PORT'] . "\n";
echo "MAIL_USERNAME: " . $_ENV['MAIL_USERNAME'] . "\n";
echo "MAIL_ENCRYPTION: " . $_ENV['MAIL_ENCRYPTION'] . "\n";

// Try to send a test email
try {
    $transport = new Swift_SmtpTransport($_ENV['MAIL_HOST'], $_ENV['MAIL_PORT'], $_ENV['MAIL_ENCRYPTION']);
    $transport->setUsername($_ENV['MAIL_USERNAME']);
    $transport->setPassword($_ENV['MAIL_PASSWORD']);
    
    $mailer = new Swift_Mailer($transport);
    
    $message = (new Swift_Message('Test Email'))
        ->setFrom([$_ENV['MAIL_FROM_ADDRESS'] => $_ENV['MAIL_FROM_NAME']])
        ->setTo([$_ENV['MAIL_USERNAME']])
        ->setBody('This is a test email to verify SMTP configuration.');
    
    $result = $mailer->send($message);
    
    if ($result) {
        echo "✅ Email sent successfully!\n";
    } else {
        echo "❌ Failed to send email.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
