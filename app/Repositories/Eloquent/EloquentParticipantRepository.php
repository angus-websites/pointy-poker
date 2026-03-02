<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Models\Participant;
use App\Models\Room;
use Illuminate\Support\Collection;

class EloquentParticipantRepository implements ParticipantRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getActiveForRoom(Room $room, int $seconds = 10): Collection
    {
        $cutoff = now()->subSeconds($seconds);

        return $room->participants()
            ->where('last_seen_at', '>=', $cutoff)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function touch(Participant $participant): void
    {
        $participant->update([
            'last_seen_at' => now(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function addToRoom(Room $room, string $name, string $token): Participant
    {
        return $room->participants()->create([
            'name' => $name,
            'last_seen_at' => now(),
            'token' => $token,
        ]);
    }
}
