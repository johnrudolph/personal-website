<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'hi@johnrudolphdrexler.com')],
            [
                'name' => env('ADMIN_NAME', 'John Drexler'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'change-me-please')),
                'email_verified_at' => now(),
            ]
        );
    }
}
