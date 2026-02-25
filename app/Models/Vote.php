<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $round_id
 * @property string $participant_key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Vote extends Model
{
    protected $fillable = [
        'round_id',
        'participant_key',
        'value',
    ];
}
