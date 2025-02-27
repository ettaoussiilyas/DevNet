<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users or create some if none exist
        $users = User::all();

//        if ($users->isEmpty()) {
//            // Create a test user if none exists
//            $users = User::factory()->count(3)->create();
//        }

        foreach ($users as $user) {
            Project::create([
                'name' => 'Project ' . fake()->word(),
                'descreption' => fake()->unique()->sentence(),
                'user_id' => $user->id
            ]);
        }
    }
}
