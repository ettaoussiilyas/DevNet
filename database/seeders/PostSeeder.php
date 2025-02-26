<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2-5 posts for each user
        User::all()->each(function ($user) {
            Post::factory()
                ->count(fake()->numberBetween(2, 5))
                ->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
