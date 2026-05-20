<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->ensureDefaultUsers();
    }

    /**
     * Guarantee that the two protected default accounts always exist
     * with the correct credentials and roles. Runs once per process.
     */
    private function ensureDefaultUsers(): void
    {
        static $checked = false;
        if ($checked) {
            return;
        }
        $checked = true;

        try {
            if (!Schema::hasTable('users')) {
                return;
            }

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
        } catch (\Throwable $e) {
            // Silently skip if DB is not ready (e.g. during migrations)
        }
    }
}
