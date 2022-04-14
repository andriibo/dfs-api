<?php

namespace App\Enums\Users;

use ArchTech\Enums\Names;

enum RoleEnum
{
    use Names;

    case user;

    case admin;
}
