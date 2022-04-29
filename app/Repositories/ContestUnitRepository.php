<?php

namespace App\Repositories;

use App\Models\Contests\ContestUnit;
use Illuminate\Database\Eloquent\Collection;

class ContestUnitRepository
{
    public function getContestUnitsByContestId(int $contestId): Collection
    {
        return ContestUnit::query()
            ->whereContestId($contestId)
            ->get()
            ;
    }
}
