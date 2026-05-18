<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cmp.com'],
            [
                'name' => 'Admin-Leo',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member-V',
                'password' => Hash::make('member123'),
                'role' => 'member',
            ]
        );
    }
}