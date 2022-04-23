<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum PrizeBankTypeEnum: int
{
    use Values;

    case bankTypeWta = 1;

    case bankTypeTopThree = 2;

    case bankTypeFiftyFifty = 3;

    case bankTypeCustomPayout = 4;
}
