<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            Comment::factory()
                ->count(3)
                ->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id
                ]);
        }
    }
}
