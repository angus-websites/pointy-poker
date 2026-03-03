<?php

namespace App\Services;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\RoundContract;
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
     * Start a new round in the given room.
     */
    public function newRound(RoomContract $room): RoundContract
    {
        // Create a new round for the room
        return $this->roundRepository->createForRoom($room);

        // TODO delete old rounds

    }

    /**
     * Get all active participants in a room along with their votes for the current round.
     *
     * @return Collection<int, array{ id: int, name: string, vote: string|null }>
     */
    public function getActiveParticipantsWithVotes(RoomContract $room): Collection
    {

        // Get the active participants in the room
        $participants = $this->participantRepository
            ->getActiveForRoom($room);

        // Get the current round for the room
        $round = $room->getCurrentRound();

        // Init empty collection for votes
        $votes = collect();

        if ($round) {
            $votes = $this->voteRepository
                ->getForRound($round)
                ->keyBy(fn ($vote) => $vote->getParticipantId());
        }

        // Return a collection of participants with their votes (if any)
        return $participants->map(function ($participant) use ($votes) {

            $vote = $votes->get($participant->getId());

            return (object) [
                'id' => $participant->getId(),
                'name' => $participant->getName(),
                'vote' => $vote?->getValue(),
            ];
        });

    }
}
