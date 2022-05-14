<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class UnitStatsHelper
{
    public static function mapStats(array $stats, Collection $actionPoints): array
    {
        $formattedStats = [];
        foreach ($actionPoints as $actionPoint) {
            $formattedStats[] = (object) [
                'value' => $stats[$actionPoint->name] ?? 0,
                'title' => $actionPoint->title,
                'alias' => $actionPoint->alias,
            ];
        }

        return $formattedStats;
    }

    /**
     * Sum values of corresponding keys from two or more arrays, values from later arrays are added to former array.
     */
    public static function sumStats(array $stats): array
    {
        if (!count($stats)) {
            return [];
        }

        if (1 == count($stats)) {
            return $stats[0];
        }

        [$ar1, $ar2] = $stats;
        if (count($stats) > 2) {
            $ar2 = self::sumStats(array_slice($stats, 1));
        }
        foreach ($ar2 as $key => $value) {
            $ar1[$key] = isset($ar1[$key]) ? $ar1[$key] + $value : $value;
        }

        return $ar1;
    }
}
