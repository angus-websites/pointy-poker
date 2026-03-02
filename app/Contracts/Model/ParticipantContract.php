<?php
namespace App\Contracts\Model;

use Illuminate\Support\Collection;

interface ParticipantContract
{
    /**
     * Get the unique ID of the participant.
     */
    public function getId(): int;

    /**
     * Get the participant's name.
     */
    public function getName(): string;

    /**
     * Get the last seen timestamp (for live/active participants).
     */
    public function getLastSeenAt(): ?\DateTimeImmutable;

    /**
     * Update the last seen timestamp to now.
     */
    public function touch(): void;

    /**
     * Get votes cast by this participant.
     *
     * @return Collection<int, VoteContract>
     */
    public function getVotes(): Collection;
}
