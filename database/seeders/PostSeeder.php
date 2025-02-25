<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Post::factory()
                ->count(5)
                ->create([
                    'user_id' => $user->id
                ]);
        }
    }
}
