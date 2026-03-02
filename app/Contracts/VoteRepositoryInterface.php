<?php

namespace App\Contracts;

use App\Models\Participant;
use App\Models\Round;
use App\Models\Vote;
use Illuminate\Support\Collection;

interface VoteRepositoryInterface
{
    /**
     * Get all votes for a round.
     */
    public function getForRound(Round $round): Collection;

    /**
     * Get the vote cast by a participant in a round, or null if they haven't voted.
     */
    public function getForParticipant(Round $round, Participant $participant): ?Vote;

    /**
     * Cast a vote for a participant in a round. If the participant has already voted, update their vote.
     */
    public function cast(Round $round, Participant $participant, string $value): Vote;

}
