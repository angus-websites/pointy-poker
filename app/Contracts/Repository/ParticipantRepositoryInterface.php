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
     * @param  RoomContract  $room  The room to fetch participants for.
     * @param  int  $seconds  The number of seconds to consider a participant active.
     * @return Collection<int, ParticipantContract>
     */
    public function getActiveForRoom(RoomContract $room, int $seconds = 10): Collection;

    /**
     * Add a new participant to a room.
     */
    public function create(RoomContract $room, array $data): ParticipantContract;
}
