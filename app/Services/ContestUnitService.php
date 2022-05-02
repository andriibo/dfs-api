<?php

namespace App\Services;

use App\Enums\SportIdEnum;
use App\Models\Contests\ContestUnit;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class ContestUnitService
{
    public function getUnit(ContestUnit $contestUnit): Model
    {
        $sportId = $contestUnit->sport_id;
        if ($sportId == SportIdEnum::soccer->value) {
            return $contestUnit->soccerUnit;
        }

        if ($sportId == SportIdEnum::cricket->value) {
            return $contestUnit->cricketUnit;
        }

        throw new \Exception('Could not find unit for this sport', Response::HTTP_NOT_FOUND);
    }
}
