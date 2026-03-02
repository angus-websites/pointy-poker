<?php

namespace App\Contracts\Repository;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use Illuminate\Support\Collection;

interface ParticipantRepositoryInterface
{
    /**
     * Fetch all active participants for a room.
     * A participant is considered active if they have been touched within the last $seconds seconds.
     *
     * @return Collection<int, ParticipantContract>
     */
    public function getActiveForRoom(RoomContract $room, int $seconds = 10): Collection;

    /**
     * A heartbeat method to update the last active timestamp of a participant.
     */
    public function touch(ParticipantContract $participant): void;

    /**
     * Add a new participant to a room.
     */
    public function create(RoomContract $room, array $data): ParticipantContract;
}
