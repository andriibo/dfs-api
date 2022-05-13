<?php

namespace App\Repositories;

use App\Models\Contests\ContestUnit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContestUnitRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getContestUnitById(int $contestUnitId): ContestUnit
    {
        return ContestUnit::findOrFail($contestUnitId)
            ;
    }

    public function getContestUnitsByContestId(int $contestId): Collection
    {
        return ContestUnit::query()
            ->whereContestId($contestId)
            ->get()
            ;
    }
}
