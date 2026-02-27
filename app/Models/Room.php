<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A Room represents a planning poker session. It has many Participants and Rounds.
 *
 * @property int $id]
 * @property int $owner_id
 * @property string $name
 * @property string $slug
 */
class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    protected $fillable = ['name', 'owner_id', 'slug'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the rounds for the room.
     */
    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    /**
     * Get the latest round for the room
     */
    public function round(): ?Round
    {
        return $this->rounds()->latest()->first();

    }

    /**
     * Get the participants for the room.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
