<?php

namespace App\Services;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Contracts\Repository\RoomRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoomService
{
    protected CodeGeneratorService $codeGeneratorService;

    public function __construct(
        protected RoomRepositoryInterface $roomRepository,
        protected ParticipantRepositoryInterface $participantRepository,
    ) {
        $this->codeGeneratorService = new CodeGeneratorService($roomRepository);
    }

    /**
     * Create a new room for a user.
     *
     * @param  string  $name  The name of the room
     * @return RoomContract The created room
     *
     * @throws CodeGeneratorException
     */
    public function create(string $name): RoomContract
    {
        $owner = Auth::user();
        $code = $this->codeGeneratorService->generate();

        return $this->roomRepository->create($owner, [
            'name' => $name,
            'code' => $code,
        ]);
    }

    /**
     * Generate a unique room code.
     *
     * TODO move this into service, auto increment length
     */
    protected function generateUniqueCode(int $length = 6): string
    {
        $maxAttempts = 10;
        $attempt = 0;

        do {
            $code = Str::upper(Str::random($length));
            $exists = $this->roomRepository->findBySlug($code);

            $attempt++;

            if ($attempt >= $maxAttempts) {
                throw new \RuntimeException('Unable to generate unique room code.');
            }

        } while ($exists !== null);

        return $code;
    }

    /**
     * Get paginated rooms for the authenticated user.
     */
    public function paginateRooms(): LengthAwarePaginator
    {
        $perPage = 10;
        $user = Auth::user();

        return $this->roomRepository->paginate($user, $perPage);
    }

    /**
     * Get a room by its code
     *
     * @throws ModelNotFoundException
     */
    public function getRoomByCode(string $code): RoomContract
    {
        $room = $this->roomRepository->findByCode($code);

        if (! $room) {
            throw new ModelNotFoundException("Room with code '{$code}' not found.");
        }

        return $room;

    }

    /**
     * Create a participant for a room and store a cookie for future recognition.
     */
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
