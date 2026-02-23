<?php

namespace App\Models;

use App\Enum\RoundStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * A Round represents a single round of voting in a Room. It belongs to a Room and has many Votes.
 *
 * @property int $id
 * @property int $room_id
 * @property string $status
 */
class Round extends Model
{

    protected $casts = [
        'status' => RoundStatus::class,
    ];
}
