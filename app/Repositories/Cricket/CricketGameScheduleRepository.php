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

    public function getNextGameSchedule(int $contestId, int $teamId): ?CricketGameSchedule
    {
        return CricketGameSchedule::query()
            ->join('contest_game', 'cricket_game_schedule.id', '=', 'contest_game.game_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::soccer)
            ->where('cricket_game_schedule.home_team_id', $teamId)
            ->orWhere('cricket_game_schedule.away_team_id', $teamId)
            ->where('cricket_game_schedule.game_date', '>', date('Y-m-d H:i:s'))
            ->orderBy('cricket_game_schedule.game_date')
            ->first()
            ;
    }
}
