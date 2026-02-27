<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $round_id
 * @property string $participant_id
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Vote extends Model
{
    protected $fillable = [
        'round_id',
        'participant_id',
        'value',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}
