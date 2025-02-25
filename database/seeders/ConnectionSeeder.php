<?php

namespace Database\Seeders;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $receivers = $users->except($user->id)->random(3);
            foreach ($receivers as $receiver) {
                Connection::create([
                    'sender_id' => $user->id,
                    'receiver_id' => $receiver->id,
                    'status' => fake()->randomElement(['pending', 'accepted', 'rejected'])
                ]);
            }
        }
    }
}
