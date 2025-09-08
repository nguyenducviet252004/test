<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/debug/email-config', function () {
    return response()->json([
        'mail_mailer' => config('mail.default'),
        'mail_host' => config('mail.mailers.smtp.host'),
        'mail_port' => config('mail.mailers.smtp.port'),
        'mail_username' => config('mail.mailers.smtp.username'),
        'mail_password' => config('mail.mailers.smtp.password') ? '***hidden***' : 'not set',
        'mail_encryption' => config('mail.mailers.smtp.encryption'),
        'mail_from_address' => config('mail.from.address'),
        'mail_from_name' => config('mail.from.name'),
    ]);
});

Route::get('/debug/test-email/{email?}', function ($email = null) {
    $email = $email ?? config('mail.from.address');
    
    try {
        Mail::raw('Test email from Laravel - ' . now(), function ($message) use ($email) {
            $message->to($email)
                    ->subject('Test Email - ' . now());
        });
        
        return response()->json([
            'status' => 'success',
            'message' => 'Email sent successfully to ' . $email,
            'timestamp' => now()
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});
