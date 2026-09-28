<?php

namespace App\Contracts\Model;

use Illuminate\Support\Collection;

/**
 * Domain-level contract for a planning poker room.
 */
interface RoomContract
{
    /**
     * Get the unique ID of the room.
     */
    public function getId(): int;

    /**
     * Get the name of the room.
     */
    public function getName(): string;

    /**
     * Get the code for the room.
     */
    public function getCode(): string;

    /**
     * Get the ID of the owner.
     */
    public function getOwnerId(): int;

    /**
     * Get all participants in the room.
     *
     * @return Collection<int, ParticipantContract>
     */
    public function getParticipants(): Collection;

    /**
     * Get a participant by ID.
     */
    public function getParticipant(int $participantId): ?ParticipantContract;

    /**
     * Get a participant by token.
     */
    public function getParticipantByToken(string $token): ?ParticipantContract;

    /**
     * Get all rounds for the room.
     *
     * @return Collection<int, RoundContract>
     */
    public function getRounds(): Collection;

    /**
     * Get the current/latest round.
     */
    public function getCurrentRound(): ?RoundContract;
}
