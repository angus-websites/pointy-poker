<?php

namespace App\Services;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Model\UserContract;
use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Contracts\Repository\RoomRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RoomService
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepository,
        protected ParticipantRepositoryInterface $participantRepository,
    ) {}

    /**
     * Get rooms owned by a specific user.
     *
     * @return Collection<int, RoomContract>
     */
    public function getOwnedRooms(UserContract $user): Collection
    {
        return $this->roomRepository->getByOwner($user);
    }

    /**
     * Get a room by its slug.
     *
     * @throws ModelNotFoundException
     */
    public function getRoomBySlug(string $slug): RoomContract
    {
        $room = $this->roomRepository->findBySlug($slug);

        if (! $room) {
            throw new ModelNotFoundException("Room with slug '{$slug}' not found.");
        }

        return $room;

    }

    public function createParticipant(RoomContract $room, string $name): ParticipantContract
    {

        // Generate a token
        $token = (string) Str::uuid();

        // Create the participant
        $participant = $this->participantRepository->create($room, [
            'name' => $name,
            'token' => $token,
        ]);

        // Store a cookie
        cookie()->queue(
            cookie(
                'pokey_participant_'.$room->getId(),
                encrypt(json_encode([
                    'token' => $token,
                ])),
                60 * 24 * 365 // 1 year
            )
        );

        return $participant;
    }
}
