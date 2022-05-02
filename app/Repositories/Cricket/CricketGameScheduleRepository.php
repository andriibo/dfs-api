<?php

namespace App\Repositories\Cricket;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Database\Eloquent\Collection;

class CricketGameScheduleRepository
{
    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getGameSchedulesByContestId(int $contestId): Collection
    {
        return CricketGameSchedule::query()
            ->join('contest_game', 'cricket_game_schedule.id', '=', 'contest_game.game_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::cricket)
            ->get()
        ;
    }
}
