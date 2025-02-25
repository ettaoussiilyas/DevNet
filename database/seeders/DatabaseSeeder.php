<?php

namespace Database\Seeders;

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
            ConnectionSeeder::class,
            LikeSeeder::class
        ]);
    }
}
