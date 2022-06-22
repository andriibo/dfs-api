<?php

namespace App\Repositories\Soccer;

use App\Enums\IsFakeEnum;
use App\Models\Soccer\SoccerUnitStats;
use Illuminate\Support\Collection;

class SoccerUnitStatsRepository
{
    /**
     * @return Collection|SoccerUnitStats[]
     */
    public function getUnitStatsByUnitId(int $unitId, ?int $limit = null): Collection
    {
        return SoccerUnitStats::query()
            ->join('game_schedule', 'game_schedule.id', '=', 'unit_stats.game_id')
            ->where('unit_stats.unit_id', $unitId)
            ->whereNotNull('unit_stats.game_id')
            ->where('game_schedule.is_fake', IsFakeEnum::no)
            ->orderByDesc('game_schedule.game_date')
            ->limit($limit)
            ->get()
        ;
    }
}
