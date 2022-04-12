<?php

namespace App\Enums\FileUploads;

use ArchTech\Enums\Values;

enum FileTypeEnum: int
{
    use Values;

    case unknown = 0;

    case image = 1;

    case video = 2;

    case audio = 3;

    case text = 4;
}
