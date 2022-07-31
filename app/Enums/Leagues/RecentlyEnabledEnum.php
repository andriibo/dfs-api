<?php

namespace App\Enums\Leagues;

use ArchTech\Enums\Values;

enum RecentlyEnabledEnum: int
{
    use Values;

    case recentlyNotEnabled = 0;

    case recentlyEnabled = 1;
}
