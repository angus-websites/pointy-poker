<?php

namespace App\Models;

use Carbon\Carbon;
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
class Participant extends Model
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
}
