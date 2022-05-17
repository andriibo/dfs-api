<?php

namespace App\Repositories\Cricket;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getNextGameSchedule(int $teamId): ?CricketGameSchedule
    {
        return CricketGameSchedule::query()
            ->where('cricket_game_schedule.home_team_id', $teamId)
            ->orWhere('cricket_game_schedule.away_team_id', $teamId)
            ->where('cricket_game_schedule.game_date', '>', DB::raw('NOW()'))
            ->orderBy('cricket_game_schedule.game_date')
            ->first()
            ;
    }
}
