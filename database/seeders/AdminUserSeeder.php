<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create (or update) the admin account for the Filament panel at /admin.
     *
     * Credentials can be overridden via .env:
     *   ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD
     *
     * Run standalone with:  php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'info@shama.com');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'shamoo@546')),
                'is_admin' => true,
            ],
        );

        $this->command?->info("Admin user ready: {$email}");
    }
}
