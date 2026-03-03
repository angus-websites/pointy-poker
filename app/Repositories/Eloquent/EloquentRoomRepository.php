<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Model\RoomContract;
use App\Contracts\Model\UserContract;
use App\Contracts\Repository\RoomRepositoryInterface;
use App\Enum\RoundStatus;
use App\Models\Room;
use App\Models\Round;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function paginate(
        UserContract $user,
        int $perPage
    ): LengthAwarePaginator {
        return Room::where('owner_id', $user->getId())
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * {@inheritDoc}
     */
    public function findById(int $id): ?RoomContract
    {
        return Room::find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findByCode(string $code): ?RoomContract
    {
        return Room::where('code', $code)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function create(UserContract $owner, array $data = []): RoomContract
    {

        // TODO wrap in transaction to ensure both room and round are created successfully
        $room = Room::create([
            'owner_id' => $owner->getId(),
            'name' => $data['name'],
            'code' => $data['code'],
        ]);

        // Create an initial round for the room
        Round::create([
            'room_id' => $room->getId(),
            'status' => RoundStatus::IDLE,
        ]);

        return $room;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(RoomContract $room): bool
    {
        return Room::destroy($room->getId());
    }

}
