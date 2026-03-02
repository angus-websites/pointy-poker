<?php

namespace App\Contracts\Repository;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\UserContract;
use Illuminate\Support\Collection;

interface RoomRepositoryInterface
{
    /**
     * Get all rooms owned by a user.
     *
     * @param UserContract $owner
     * @return Collection<int, RoomContract>
     */
    public function getByOwner(UserContract $owner): Collection;

    /**
     * Find room by ID.
     *
     * @param int $id
     * @return RoomContract|null
     */
    public function findById(int $id): ?RoomContract;

    /**
     * Find room by slug.
     *
     * @param string $slug
     * @return RoomContract|null
     */
    public function findBySlug(string $slug): ?RoomContract;

    /**
     * Create a new room for a user.
     *
     * @param UserContract $owner
     * @param array $data
     * @return RoomContract
     */
    public function create(UserContract $owner, array $data = []): RoomContract;

    /**
     * Delete a room.
     *
     * @param RoomContract $room
     * @return bool
     */
    public function delete(RoomContract $room): bool;
}
