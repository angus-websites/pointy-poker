<?php

namespace App\Contracts\Repository;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\UserContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RoomRepositoryInterface extends CodeRepositoryInterface
{
    /**
     * Get paginated rooms for a user.
     */
    public function paginate(
        UserContract $user,
        int $perPage
    ): LengthAwarePaginator;

    /**
     * Find room by ID.
     */
    public function findById(int $id): ?RoomContract;

    /**
     * Find room by slug.
     */
    public function findByCode(string $code): ?RoomContract;

    /**
     * Create a new room for a user.
     */
    public function create(UserContract $owner, array $data = []): RoomContract;

    /**
     * Delete a room.
     */
    public function delete(RoomContract $room): bool;
}
