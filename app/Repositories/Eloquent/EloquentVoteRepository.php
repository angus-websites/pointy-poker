<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\VoteRepositoryInterface;
use App\Models\Participant;
use App\Models\Round;
use App\Models\Vote;
use Illuminate\Support\Collection;

class EloquentVoteRepository implements VoteRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getForRound(Round $round): Collection
    {
        return $round->votes()->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getForParticipant(Round $round, Participant $participant): ?Vote
    {
        return $round->votes()
            ->where('participant_id', $participant->id)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function cast(Round $round, Participant $participant, string $value): Vote
    {
        return Vote::updateOrCreate(
            [
                'round_id' => $round->id,
                'participant_id' => $participant->id,
            ],
            [
                'value' => $value,
            ]
        );
    }
}
