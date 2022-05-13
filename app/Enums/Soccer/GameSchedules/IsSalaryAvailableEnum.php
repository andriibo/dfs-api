<?php

namespace App\Enums\Soccer\GameSchedules;

use ArchTech\Enums\Values;

enum IsSalaryAvailableEnum: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
