<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class ActionPointHelper
{
    public static function getScore(int $gameLogValue, array $actionPointValues, int $unitPosition): float
    {
        $unitValue = Arr::get($actionPointValues, $unitPosition, 0);

        return $gameLogValue * $unitValue;
    }
}
