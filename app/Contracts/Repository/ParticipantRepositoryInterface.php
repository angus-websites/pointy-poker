<?php

namespace App\Contracts\Repository;

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Support\Collection;

interface ParticipantRepositoryInterface
{
    /**
     * Fetch all active participants for a room.
     * A participant is considered active if they have been touched within the last $seconds seconds.
     */
    public function getActiveForRoom(Room $room, int $seconds = 10): Collection;

    /**
     * A heartbeat method to update the last active timestamp of a participant.
     */
    public function touch(Participant $participant): void;

    /**
     * Add a new participant to a room.
     */
    public function addToRoom(Room $room, string $name, string $token): Participant;
}
