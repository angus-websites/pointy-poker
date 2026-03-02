<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\RoundContract;
use App\Contracts\Repository\RoundRepositoryInterface;
use App\Enum\RoundStatus;
use App\Models\Round;

class EloquentRoundRepository implements RoundRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getCurrentForRoom(RoomContract $room): ?RoundContract
    {
        return $room->getCurrentRound();
    }

    /**
     * {@inheritDoc}
     */
    public function createForRoom(RoomContract $room, RoundStatus $status): RoundContract
    {
        return Round::create([
            'room_id' => $room->getId(),
            'status' => $status,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function updateStatus(RoundContract $round, RoundStatus $status): void
    {
        $round->setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(RoundContract $round): void
    {
        Round::destroy($round->getId());
    }
}
