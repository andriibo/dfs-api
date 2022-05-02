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
}
