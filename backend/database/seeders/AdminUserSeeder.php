<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'fullname' => 'Administrator',
            'role' => 1, // Admin
            'is_active' => 1,
            'phone' => '0123456789',
            'address' => 'Hà Nội, Việt Nam',
            'birth_day' => '1990-01-01',
        ]);

        // Tạo tài khoản user thường
        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('123456'),
            'fullname' => 'Regular User',
            'role' => 0, // User thường
            'is_active' => 1,
            'phone' => '0987654321',
            'address' => 'TP.HCM, Việt Nam',
            'birth_day' => '1995-01-01',
        ]);

        echo "Created admin user: admin@example.com / 123456\n";
        echo "Created regular user: user@example.com / 123456\n";
    }
}
