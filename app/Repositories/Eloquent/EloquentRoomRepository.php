<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\UserContract;
use App\Contracts\Repository\RoomRepositoryInterface;
use App\Enum\RoundStatus;
use App\Models\Room;
use App\Models\Round;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByOwner(UserContract $owner): Collection
    {
        return Room::where('owner_id', $owner->getId())
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
    public function create(UserContract $owner, array $data = []): Room
    {
        $room = Room::create([
            'owner_id' => $owner->getId(),
            'name' => $data['name'] ?? null,
            'slug' => $this->generateUniqueSlug(),
        ]);

        // Create an initial round for the room
        Round::create([
            'room_id' => $room->getId(),
            'status' => RoundStatus::IDLE,
        ]);

        return $room;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(RoomContract $room): bool
    {
        return Room::destroy($room->getId());
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
