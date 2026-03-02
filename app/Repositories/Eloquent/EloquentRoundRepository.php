<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\RoundRepositoryInterface;
use App\Enum\RoundStatus;
use App\Models\Room;
use App\Models\Round;

class EloquentRoundRepository implements RoundRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getCurrentForRoom(Room $room): ?Round
    {
        return $room->rounds()
            ->latest()
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function createForRoom(Room $room, RoundStatus $status): Round
    {
        return $room->rounds()->create([
            'status' => $status,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function updateStatus(Round $round, RoundStatus $status): void
    {
        $round->update([
            'status' => $status,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Round $round): void
    {
        $round->delete();
    }
}
