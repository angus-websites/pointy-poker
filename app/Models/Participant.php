<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * A participant in a room, which can be either an authenticated user or an anonymous visitor identified by a browser token.
 *
 * @property int $id
 * @property int $room_id
 * @property string $display_name
 * @property string|null $token
 * @property Carbon|null $last_seen_at
 */
class Participant extends Model
{
    protected $fillable = [
        'room_id',
        'token',
        'display_name',
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
