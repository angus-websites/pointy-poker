<?php

namespace App\Models;

use App\Enum\RoundStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A Round represents a single round of voting in a Room. It belongs to a Room and has many Votes.
 *
 * @property int $id
 * @property int $room_id
 * @property RoundStatus $status
 */
class Round extends Model
{
    protected $casts = [
        'status' => RoundStatus::class,
    ];

    protected $fillable = [
        'room_id',
        'status',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
