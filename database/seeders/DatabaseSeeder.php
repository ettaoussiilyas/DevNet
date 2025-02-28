<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            HashTagSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            NotificationSeeder::class,
            MessageSeeder::class,
            ProjectSeeder::class,
            LikesSeeder::class,
        ]);
    }
}
