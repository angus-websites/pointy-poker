<?php

namespace App\Contracts\Model;

use App\Enum\RoundStatus;
use Illuminate\Support\Collection;

interface RoundContract
{
    /**
     * Get the unique ID of the round.
     */
    public function getId(): int;

    /**
     * Get the status of the round.
     */
    public function getStatus(): RoundStatus;

    /**
     * Set/update the status of the round.
     */
    public function setStatus(RoundStatus $status): void;

    /**
     * Get all votes for this round.
     *
     * @return Collection<int, VoteContract>
     */
    public function getVotes(): Collection;

    /**
     * Get a vote by participant ID.
     */
    public function getVote(ParticipantContract $participant): ?VoteContract;

    /**
     * Cast or update a vote for a participant.
     */
    public function castVote(ParticipantContract $participant, string $value): void;
}
