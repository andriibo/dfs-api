<?php

namespace App\Repositories;

use App\Models\Contests\ContestUserUnit;

class ContestUserUnitRepository
{
    public function create(array $attributes = []): ContestUserUnit
    {
        return ContestUserUnit::create($attributes);
    }
}
