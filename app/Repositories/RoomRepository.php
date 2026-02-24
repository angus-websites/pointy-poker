<?php

namespace App\Repositories;

use App\Contracts\RoomRepositoryInterface;
use App\Models\Participant;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RoomRepository implements RoomRepositoryInterface
{
    /**
     * Get all rooms owned by a user.
     */
    public function getByOwner(User $user): Collection
    {
        return Room::where('owner_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Find room by ID.
     */
    public function findById(int $id): ?Room
    {
        return Room::find($id);
    }

    /**
     * Find room by slug.
     */
    public function findBySlug(string $slug): ?Room
    {
        return Room::where('slug', $slug)->first();
    }

    /**
     * Find a participant by their token.
     */
    public function findParticipantByToken(int $room_id, string $token): ?Participant
    {
        return Participant::where('room_id', $room_id)
            ->where('token', $token)
            ->first();
    }

    /**
     * Create a new room for a user.
     */
    public function create(User $owner, array $data = []): Room
    {
        return Room::create([
            'owner_id' => $owner->id,
            'name' => $data['name'] ?? null,
            'slug' => $this->generateUniqueSlug(),
        ]);
    }

    /**
     * Delete a room.
     */
    public function delete(Room $room): bool
    {
        return (bool) $room->delete();
    }

    /**
     * Generate a unique slug.
     */
    protected function generateUniqueSlug(): string
    {
        do {
            $slug = Str::random(8);
        } while (Room::where('slug', $slug)->exists());

        return $slug;
    }
}
