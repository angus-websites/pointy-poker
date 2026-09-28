<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->words(3, true),
            'code' => Str::upper(Str::random(6)),
        ];
    }

    /**
     * Attach to a specific owner.
     */
    public function forOwner(User $user): static
    {
        return $this->state(fn () => [
            'owner_id' => $user->id,
        ]);
    }
}
