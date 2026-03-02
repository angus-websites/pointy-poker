<?php

namespace App\Contracts\Repository;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoundContract;
use App\Contracts\Model\VoteContract;
use Illuminate\Support\Collection;

interface VoteRepositoryInterface
{
    /**
     * Get all votes for a round.
     *
     * @return Collection<int, VoteContract>
     */
    public function getForRound(RoundContract $round): Collection;

    /**
     * Get the vote cast by a participant in a round, or null if they haven't voted.
     */
    public function getForParticipant(RoundContract $round, ParticipantContract $participant): ?VoteContract;

    /**
     * Cast a vote for a participant in a round. If the participant has already voted, update their vote.
     */
    public function cast(RoundContract $round, ParticipantContract $participant, string $value): VoteContract;
}
