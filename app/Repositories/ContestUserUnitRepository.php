<?php

namespace App\Repositories;

use App\Models\Contests\ContestUserUnit;

class ContestUserUnitRepository
{
    public function updateOrCreate(array $attributes, array $values = []): ContestUserUnit
    {
        return ContestUserUnit::updateOrCreate($attributes, $values);
    }
}
