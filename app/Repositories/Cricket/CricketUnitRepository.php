<?php

namespace App\Repositories\Cricket;

use App\Models\Cricket\CricketUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CricketUnitRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getUnitById(int $id): CricketUnit
    {
        return CricketUnit::findOrFail($id);
    }
}
