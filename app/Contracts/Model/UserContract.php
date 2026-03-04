<?php

namespace App\Contracts\Model;

use Illuminate\Support\Collection;

interface UserContract
{
    /**
     * Get the unique ID of the user.
     */
    public function getId(): int;

    /**
     * Get the name of the user.
     */
    public function getName(): string;

    /**
     * Get all rooms owned by the user.
     *
     * @return Collection<int, RoomContract>
     */
    public function getRooms(): Collection;

    /**
     * Check if the user owns a specific room.
     */
    public function ownsRoom(RoomContract $room): bool;
}
