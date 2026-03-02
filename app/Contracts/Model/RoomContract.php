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
     * Get the slug for the room.
     */
    public function getSlug(): string;

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
     * Add a participant to the room.
     */
    public function addParticipant(ParticipantContract $participant): void;

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

    /**
     * Add a new round to this room.
     */
    public function addRound(RoundContract $round): void;

}
