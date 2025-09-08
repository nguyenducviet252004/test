<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Exception;

class TestEmail extends Command
{
    protected $signature = 'email:test {email?}';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $email = $this->argument('email') ?? config('mail.from.address');
        
        $this->info('Testing email configuration...');
        $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->info('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
        $this->info('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
        $this->info('Sending test email to: ' . $email);
        
        try {
            Mail::raw('This is a test email to verify SMTP configuration.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - Laravel SMTP Configuration');
            });
            
            $this->info('✅ Email sent successfully!');
            return 0;
            
        } catch (Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
