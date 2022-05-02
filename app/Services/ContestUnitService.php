<?php

namespace App\Services;

use App\Models\Contests\ContestUnit;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class ContestUnitService
{
    public function getUnit(ContestUnit $contestUnit): Model
    {
        if ($contestUnit->isSportSoccer()) {
            return $contestUnit->soccerUnit;
        }

        if ($contestUnit->isSportCricket()) {
            return $contestUnit->cricketUnit;
        }

        throw new \Exception('Could not find unit for this sport', Response::HTTP_NOT_FOUND);
    }
}
