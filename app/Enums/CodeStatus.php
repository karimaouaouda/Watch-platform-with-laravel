<?php

namespace App\Enums;

enum CodeStatus : string
{
    case UNUSED = 'unused';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
}
