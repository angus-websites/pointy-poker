<?php

namespace App\Contracts\Repository;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\RoundContract;
use App\Enum\RoundStatus;


interface RoundRepositoryInterface
{
    /**
     * Get the current active round for a room, or null if there is no active round.
     */
    public function getCurrentForRoom(RoomContract $room): ?RoundContract;

    /**
     * Create a new round for a room with the given status.
     */
    public function createForRoom(RoomContract $room, RoundStatus $status): RoundContract;

    /**
     * Update the status of a round.
     */
    public function updateStatus(RoundContract $round, RoundStatus $status): void;

    /**
     * Delete a round
     */
    public function delete(RoundContract $round): void;
}
