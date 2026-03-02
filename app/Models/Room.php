<?php

namespace App\Models;

use App\Contracts\Model\ParticipantContract;
use App\Contracts\Model\RoomContract;
use App\Contracts\Model\RoundContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * A Room represents a planning poker session. It has many Participants and Rounds.
 *
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string $slug
 */
class Room extends Model implements RoomContract
{
    use HasFactory;

    protected $fillable = ['name', 'owner_id', 'slug'];

    /** ---------------- Eloquent Relations ---------------- */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * {@inheritDoc}
     */
    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * {@inheritDoc}
     */
    public function getParticipants(): Collection
    {
        return $this->participants()->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getParticipant(int $participantId): ?ParticipantContract
    {
        return $this->participants()
            ->where('id', $participantId)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getRounds(): Collection
    {
        return $this->rounds()->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentRound(): ?RoundContract
    {
        return $this->rounds()
            ->latest()
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function addRound(RoundContract $round): void
    {
        if ($round instanceof Round) {
            $round->room_id = $this->id;
            $round->save();
        } else {
            throw new \InvalidArgumentException('Round must be an instance of App\Models\Round');
        }
    }

}
