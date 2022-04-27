<?php

namespace App\Factories;

use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\Soccer\SoccerGameSchedule;

class GameScheduleFactory
{
    public static function getClassName(?int $sportId): string
    {
        switch ($sportId) {
            case SportIdEnum::cricket->value:
                $className = CricketGameSchedule::class;

                break;

            default:
                $className = SoccerGameSchedule::class;
        }

        return $className;
    }
}
