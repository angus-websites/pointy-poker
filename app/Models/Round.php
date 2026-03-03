<?php

namespace App\Models;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoundContract;
use App\Contracts\Model\VoteContract;
use App\Enum\RoundStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * A Round represents a single round of voting in a Room. It belongs to a Room and has many Votes.
 *
 * @property int $id
 * @property int $room_id
 * @property RoundStatus $status
 */
class Round extends Model implements RoundContract
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

    /** ---------------- Contract Methods ---------------- */

    /**
     * {@inheritDoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus(): RoundStatus
    {
        return $this->status;
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus(RoundStatus $status): void
    {
        $this->status = $status;
        $this->save();
    }

    /**
     * {@inheritDoc}
     */
    public function getVotes(): Collection
    {
        return $this->votes()->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getVote(ParticipantContract $participant): ?VoteContract
    {
        return $this->votes()->where('participant_id', $participant->getId())->first();
    }

    /**
     * {@inheritDoc}
     */
    public function castVote(ParticipantContract $participant, string $value): void
    {
        $existingVote = $this->getVote($participant);

        if ($existingVote) {
            // Update existing vote
            $existingVote->setValue($value);
        } else {
            // Create new vote
            $this->votes()->create([
                'participant_id' => $participant->getId(),
                'value' => $value,
            ]);
        }
    }
}
