<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'liker_id' => User::factory(),
            'post_id' => Post::factory(),
            'like' => true
        ];
    }
}
