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
            ->join('soccer_game_schedule', 'soccer_game_schedule.id', '=', 'soccer_unit_stats.game_id')
            ->where('soccer_unit_stats.unit_id', $unitId)
            ->whereNotNull('soccer_unit_stats.game_id')
            ->where('soccer_game_schedule.is_fake', IsFakeEnum::no)
            ->orderByDesc('soccer_game_schedule.game_date')
            ->limit($limit)
            ->get()
        ;
    }
}
