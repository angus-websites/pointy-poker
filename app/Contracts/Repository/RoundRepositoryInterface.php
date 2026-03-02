<?php

namespace App\Contracts\Repository;

use App\Enum\RoundStatus;
use App\Models\Room;
use App\Models\Round;

interface RoundRepositoryInterface
{
    /**
     * Get the current active round for a room, or null if there is no active round.
     */
    public function getCurrentForRoom(Room $room): ?Round;

    /**
     * Create a new round for a room with the given status.
     */
    public function createForRoom(Room $room, RoundStatus $status): Round;

    /**
     * Update the status of a round.
     */
    public function updateStatus(Round $round, RoundStatus $status): void;

    /**
     * Delete a round
     */
    public function delete(Round $round): void;
}
