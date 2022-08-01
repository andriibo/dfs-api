<?php

namespace App\Repositories\Cricket;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CricketGameScheduleRepository
{
    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getGameSchedulesByContestId(int $contestId): Collection
    {
        return CricketGameSchedule::query()
            ->join('contest_game', 'cricket_game_schedule.id', '=', 'contest_game.game_schedule_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::cricket)
            ->get()
        ;
    }

    public function getNextGameSchedule(int $teamId): ?CricketGameSchedule
    {
        return CricketGameSchedule::query()
            ->where(function (Builder $query) use ($teamId) {
                $query->where('home_team_id', $teamId)
                    ->orWhere('away_team_id', $teamId)
                ;
            })
            ->where('game_date', '>', DB::raw('NOW()'))
            ->orderBy('game_date')
            ->first()
            ;
    }
}
