<?php

namespace App\Models;

use App\Contracts\Model\VoteContract;
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
class Vote extends Model implements VoteContract
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

    /** ---------------- Contract Methods ---------------- */

    /**
     * {@inheritDoc}
     */
    public function getParticipantId(): int
    {
        return $this->participant_id;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoundId(): int
    {
        return $this->round_id;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
        $this->save();
    }
}
