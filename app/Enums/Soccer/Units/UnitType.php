<?php

namespace App\Enums\Soccer\Units;

use ArchTech\Enums\Names;

enum UnitType
{
    use Names;

    case player;

    case team;
}
