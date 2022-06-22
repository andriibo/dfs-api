<?php

namespace App\Repositories;

use App\Models\Contests\ContestUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
            ->select('contest_unit.*')
            ->join('contest', 'contest.id', '=', 'contest_unit.contest_id')
            ->join('league', 'league.id', '=', 'contest.league_id')
            ->where('contest_unit.contest_id', $contestId)
            ->where('contest_unit.sport_id', '<>', 'league.sport_id')
            ->get()
            ;
    }
}
