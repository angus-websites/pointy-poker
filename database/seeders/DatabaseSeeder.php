<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\RoomFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Bob',
            'email' => 'test@example.com',
        ]);

        // Create A room
        Room::factory()
            ->forOwner($user)
            ->state(
                ['name' => 'Backlog refinement']
            )
            ->create();
    }
}
