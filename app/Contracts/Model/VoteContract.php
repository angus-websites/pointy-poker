<?php
namespace App\Contracts\Model;

interface VoteContract
{
    /**
     * Get the participant ID who cast this vote.
     */
    public function getParticipantId(): int;

    /**
     * Get the round ID this vote belongs to.
     */
    public function getRoundId(): int;

    /**
     * Get the vote value (e.g., "1", "2", "5", "8").
     */
    public function getValue(): string;

    /**
     * Set/update the vote value.
     */
    public function setValue(string $value): void;
}
