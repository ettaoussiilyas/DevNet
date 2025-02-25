<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            $likers = $users->random(rand(1, 5));
            foreach ($likers as $liker) {
                Like::create([
                    'liker_id' => $liker->id,
                    'post_id' => $post->id,
                    'like' => true
                ]);
            }
        }
    }
}
