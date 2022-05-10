<?php

namespace App\Repositories\Soccer;

use App\Enums\SportIdEnum;
use App\Models\Soccer\SoccerGameSchedule;
use Illuminate\Database\Eloquent\Collection;

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

    public function getNextGameSchedule(int $contestId, int $teamId): ?SoccerGameSchedule
    {
        return SoccerGameSchedule::query()
            ->join('contest_game', 'game_schedule.id', '=', 'contest_game.game_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::soccer)
            ->where('game_schedule.home_team_id', $teamId)
            ->orWhere('game_schedule.away_team_id', $teamId)
            ->where('game_schedule.game_date', '>', date('Y-m-d H:i:s'))
            ->orderBy('game_schedule.game_date')
            ->first()
            ;
    }
}
