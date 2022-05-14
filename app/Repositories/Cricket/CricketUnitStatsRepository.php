<?php

namespace App\Repositories\Cricket;

use App\Enums\IsFakeEnum;
use App\Models\Cricket\CricketUnitStats;
use Illuminate\Database\Eloquent\Collection;

class CricketUnitStatsRepository
{
    /**
     * @return Collection|CricketUnitStats[]
     */
    public function getUnitStatsByUnitId(int $unitId, ?int $limit = null): Collection
    {
        return CricketUnitStats::query()
            ->join('cricket_game_schedule', 'game_schedule.id', '=', 'cricket_unit_stats.game_id')
            ->where('cricket_unit_stats.unit_id', $unitId)
            ->whereNotNull('cricket_unit_stats.game_id')
            ->where('cricket_game_schedule.is_fake', IsFakeEnum::no)
            ->orderByDesc('game_schedule.game_date')
            ->limit($limit)
            ->get()
        ;
    }
}
