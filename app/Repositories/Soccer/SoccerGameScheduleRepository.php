<?php

namespace App\Repositories\Soccer;

use App\Enums\SportIdEnum;
use App\Models\Soccer\SoccerGameSchedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SoccerGameScheduleRepository
{
    /**
     * @return Collection|SoccerGameSchedule[]
     */
    public function getGameSchedulesByContestId(int $contestId): Collection
    {
        return SoccerGameSchedule::query()
            ->join('contest_game', 'game_schedule.id', '=', 'contest_game.game_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::soccer)
            ->get()
        ;
    }

    public function getNextGameSchedule(int $teamId): ?SoccerGameSchedule
    {
        return SoccerGameSchedule::query()
            ->where('home_team_id', $teamId)
            ->orWhere('away_team_id', $teamId)
            ->where('game_date', '>', DB::raw('NOW()'))
            ->orderBy('game_date')
            ->first()
            ;
    }
}
