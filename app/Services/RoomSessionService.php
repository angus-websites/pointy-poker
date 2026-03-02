<?php

namespace App\Services;

use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Contracts\Repository\RoundRepositoryInterface;
use App\Contracts\Repository\VoteRepositoryInterface;

class RoomSessionService
{
    public function __construct(
        protected RoundRepositoryInterface $rounds,
        protected VoteRepositoryInterface $votes,
        protected ParticipantRepositoryInterface $participants,
    ) {}


}
