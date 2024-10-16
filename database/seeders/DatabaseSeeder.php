<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Lars',
            'lastname' => 'de boer',
            'email' => 'lars@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);
    }
}
