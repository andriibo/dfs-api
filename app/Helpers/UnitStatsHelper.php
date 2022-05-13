<?php

namespace App\Helpers;

use App\Models\ActionPoint;

class UnitStatsHelper
{
    /**
     * @param ActionPoint[] $actionPoints
     */
    public static function mapStats(array $stats, array $actionPoints): array
    {
        $formattedStats = [];
        foreach ($actionPoints as $actionPoint) {
            $formattedStats[] = [
                'value' => $stats[$actionPoint->name] ?? 0,
                'title' => $actionPoint->title,
                'alias' => $actionPoint->alias,
            ];
        }

        return $formattedStats;
    }
}
