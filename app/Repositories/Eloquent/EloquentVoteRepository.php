<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoundContract;
use App\Contracts\Model\VoteContract;
use App\Contracts\Repository\VoteRepositoryInterface;
use App\Models\Vote;
use Illuminate\Support\Collection;

class EloquentVoteRepository implements VoteRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getForRound(RoundContract $round): Collection
    {
        return Vote::where('round_id', $round->getId())->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getForParticipant(RoundContract $round, ParticipantContract $participant): ?VoteContract
    {
        return Vote::where('round_id', $round->getId())
            ->where('participant_id', $participant->getId())
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function cast(RoundContract $round, ParticipantContract $participant, string $value): VoteContract
    {
        return Vote::updateOrCreate(
            [
                'round_id' => $round->getId(),
                'participant_id' => $participant->getId(),
            ],
            [
                'value' => $value,
            ]
        );
    }
}
