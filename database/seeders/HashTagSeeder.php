<?php

namespace Database\Seeders;

use App\Models\HashTag;
use Illuminate\Database\Seeder;

class HashTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Python', 'Java', 'DevOps'];

        foreach ($tags as $tag) {
            HashTag::create(['name' => $tag]);
        }
    }
}
