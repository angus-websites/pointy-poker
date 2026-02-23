<?php

namespace App\Enum;

enum RoundStatus: string
{
    case VOTING = 'voting';
    case REVEALED = 'revealed';
}
