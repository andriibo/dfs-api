<?php

namespace App\Repositories\Cricket;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CricketGameLogRepository
{
    public function getGameLogsByContestId(int $contestId): LengthAwarePaginator
    {
        return CricketGameLog::query()
            ->join('contest_game', 'cricket_game_log.game_schedule_id', '=', 'contest_game.game_schedule_id')
            ->where('contest_game.contest_id', $contestId)
            ->where('contest_game.sport_id', SportIdEnum::cricket)
            ->orderBy('id', 'desc')
            ->jsonPaginate()
        ;
    }
}
