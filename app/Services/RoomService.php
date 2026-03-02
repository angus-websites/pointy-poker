<?php

namespace App\Services;

use App\Contracts\Repository\RoomRepositoryInterface;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class RoomService
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepository
    ) {}

    /**
     * Get rooms owned by a specific user.
     */
    public function getOwnedRooms(User $user): Collection
    {
        return $this->roomRepository->getByOwner($user);
    }

    /**
     * Get a room by its slug.
     *
     * @throws ModelNotFoundException
     */
    public function getRoomBySlug(string $slug): Room
    {
        $room = $this->roomRepository->findBySlug($slug);

        if (! $room) {
            throw new ModelNotFoundException("Room with slug '{$slug}' not found.");
        }

        return $room;

    }

}
