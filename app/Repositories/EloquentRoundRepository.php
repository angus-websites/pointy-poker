<?php

namespace App\Repositories;

use App\Contracts\RoundRepositoryInterface;
use App\Enum\RoundStatus;
use App\Models\Room;
use App\Models\Round;

class EloquentRoundRepository implements RoundRepositoryInterface
{
    public function getCurrentForRoom(Room $room): ?Round
    {
        return $room->rounds()
            ->latest()
            ->first();
    }

    public function createForRoom(Room $room, RoundStatus $status): Round
    {
        return $room->rounds()->create([
            'status' => $status,
        ]);
    }

    public function updateStatus(Round $round, RoundStatus $status): void
    {
        $round->update([
            'status' => $status,
        ]);
    }

    public function delete(Round $round): void
    {
        $round->delete();
    }
}
