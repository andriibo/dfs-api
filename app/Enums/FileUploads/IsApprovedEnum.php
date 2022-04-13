<?php

namespace App\Enums\FileUploads;

use ArchTech\Enums\Values;

enum IsApprovedEnum: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
