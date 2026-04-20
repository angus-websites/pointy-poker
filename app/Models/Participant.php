<?php

namespace App\Models;

use App\Contracts\Model\ParticipantContract;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A participant in a room
 *
 * @property int $id
 * @property int $room_id
 * @property string $name
 * @property string|null $token
 * @property Carbon|null $last_seen_at
 */
class Participant extends Model implements ParticipantContract
{
    protected $fillable = [
        'room_id',
        'token',
        'name',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /** ---------------- Contract Methods ---------------- */
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    public function getLastSeenAt(): ?CarbonInterface
    {
        return $this->last_seen_at;
    }

    public function ping(): void
    {
        $this->last_seen_at = Carbon::now();
        $this->save();
    }
}
