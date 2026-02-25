<?php

namespace App\Enum;

enum RoundStatus: string
{
    case IDLE = 'idle';
    case VOTING = 'voting';
    case REVEALED = 'revealed';
}
