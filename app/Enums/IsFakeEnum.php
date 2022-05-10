<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum IsFakeEnum: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
