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
            'content' => fake()->realText(500), // Ensure content is not null and within 1000 chars
            'images_url' => fake()->boolean(20) ? fake()->imageUrl() : null,
            'video_url' => fake()->boolean(10) ? fake()->url() : null,
            'type' => 'post'
        ];
    }
}
