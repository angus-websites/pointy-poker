<?php

namespace App\Contracts;

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Collection;

interface RoomRepositoryInterface
{
    /**
     * Get all rooms owned by a user.
     */
    public function getByOwner(User $user): Collection;

    /**
     * Find room by ID.
     */
    public function findById(int $id): ?Room;

    /**
     * Find room by slug.
     */
    public function findBySlug(string $slug): ?Room;

    /**
     * Create a new room for a user.
     */
    public function create(User $owner, array $data = []): Room;

    /**
     * Delete a room.
     */
    public function delete(Room $room): bool;
}
