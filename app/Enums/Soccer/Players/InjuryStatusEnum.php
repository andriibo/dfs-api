<?php

namespace App\Enums\Soccer\Players;

use ArchTech\Enums\Names;

enum InjuryStatusEnum
{
    use Names;

    case normal;

    case out;

    case possible;
}
