<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->create();

        // Create a test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'biography' => 'Test user biography',
            'skills' => 'PHP, Laravel, JavaScript',
            'gitProfile' => 'https://github.com/testuser'
        ]);
    }
}
