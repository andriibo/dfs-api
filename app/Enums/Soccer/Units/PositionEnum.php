<?php

namespace App\Enums\Soccer\Units;

use ArchTech\Enums\Values;

enum PositionEnum: string
{
    use Values;

    case goalkeeper = 'Goalkeeper';

    case forward = 'Forward';

    case midfield = 'Midfield';

    case defender = 'Defender';
}
