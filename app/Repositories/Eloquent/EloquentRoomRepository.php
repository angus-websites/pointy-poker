<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\RoomRepositoryInterface;
use App\Enum\RoundStatus;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByOwner(User $user): Collection
    {
        return Room::where('owner_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function findById(int $id): ?Room
    {
        return Room::find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findBySlug(string $slug): ?Room
    {
        return Room::where('slug', $slug)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function create(User $owner, array $data = []): Room
    {
        $room = Room::create([
            'owner_id' => $owner->id,
            'name' => $data['name'] ?? null,
            'slug' => $this->generateUniqueSlug(),
        ]);

        // Create an intial round for the room
        $room->rounds()->create([
            'status' => RoundStatus::IDLE,
        ]);

        return $room;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Room $room): bool
    {
        return (bool) $room->delete();
    }

    /**
     * Generate a unique slug for the room.
     */
    protected function generateUniqueSlug(): string
    {
        do {
            $slug = Str::random(8);
        } while (Room::where('slug', $slug)->exists());

        return $slug;
    }
}
