<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'biography' => fake()->paragraph(),
            'avatar' => fake()->imageUrl(200, 200),
            'skills' => implode(',', fake()->words(3)),
            'gitProfile' => fake()->url(),
            'remember_token' => Str::random(10),
        ];
    }
}
