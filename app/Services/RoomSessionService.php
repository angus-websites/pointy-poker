<?php

namespace App\Services;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Contracts\Repository\RoundRepositoryInterface;
use App\Contracts\Repository\VoteRepositoryInterface;
use Illuminate\Support\Collection;

class RoomSessionService
{
    public function __construct(
        protected RoundRepositoryInterface $roundRepository,
        protected VoteRepositoryInterface $voteRepository,
        protected ParticipantRepositoryInterface $participantRepository,
    ) {}

    /**
     * Get all active participants in a room.
     *
     * @return Collection<int, ParticipantContract>
     */
    public function getActiveParticipants(RoomContract $room): Collection
    {
        return $this->participantRepository->getActiveForRoom($room);
    }

    public function getParticipantsVotes(RoomContract $room): Collection
    {

        // TODO combine two methods into one
        $currentRound = $room->getCurrentRound();

        if (! $currentRound) {
            return collect();
        }

        $votes = $this->voteRepository->getForRound($currentRound);

        return $votes->mapWithKeys(function ($vote) {
            return [$vote->getParticipantId() => $vote];
        });
    }
}
