<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Protected default accounts — always recreated with these exact credentials.
     */
    public const PROTECTED_EMAILS = [
        'admin@example.com',
        'memberv@example.com',
    ];

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'memberv@example.com'],
            [
                'name' => 'Member-V',
                'password' => Hash::make('member123'),
                'role' => 'member',
            ]
        );
    }
}