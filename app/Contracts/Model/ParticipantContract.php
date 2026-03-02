<?php
namespace App\Contracts\Model;

use Carbon\CarbonInterface;

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
    public function getLastSeenAt(): ?CarbonInterface;

    /**
     * Update the last seen timestamp to now.
     */
    public function ping(): void;

}
