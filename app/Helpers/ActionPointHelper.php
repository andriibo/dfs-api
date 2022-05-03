<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class ActionPointHelper
{
    public static function getScore(int $gameLogValue, array $actionPointValues, int $unitPosition): float
    {
        return $gameLogValue * Arr::get($actionPointValues, $unitPosition, 0);
    }
}
