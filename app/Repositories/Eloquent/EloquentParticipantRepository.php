<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Models\Participant;
use Illuminate\Support\Collection;

class EloquentParticipantRepository implements ParticipantRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getActiveForRoom(RoomContract $room, int $seconds = 10): Collection
    {
        $cutoff = now()->subHour();

        return Participant::where('room_id', $room->getId())
            ->where('last_seen_at', '>=', $cutoff)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function ping(ParticipantContract $participant): void
    {
        $participant->ping();
    }

    /**
     * {@inheritDoc}
     */
    public function create(RoomContract $room, array $data): ParticipantContract
    {

        return Participant::create([
            'room_id' => $room->getId(),
            'name' => $data['name'],
            'token' => $data['token'],
            'last_seen_at' => now(),
        ]);
    }
}
