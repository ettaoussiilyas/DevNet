<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraph(), // This is required
            'image' => fake()->boolean(20) ? fake()->imageUrl() : null,
            'type' => 'post'  // Since you have a type column
        ];
    }
}
