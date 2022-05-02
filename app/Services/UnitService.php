<?php

namespace App\Services;

use App\Exceptions\UnitServiceException;
use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketUnitRepository;
use App\Repositories\Soccer\SoccerUnitRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class UnitService
{
    public function __construct(
        private readonly SoccerUnitRepository $soccerUnitRepository,
        private readonly CricketUnitRepository $cricketUnitRepository
    ) {
    }

    public function getUnit(ContestUnit $contestUnit): Model
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerUnitRepository->getUnitById($contestUnit->unit_id);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketUnitRepository->getUnitById($contestUnit->unit_id);
        }

        throw new UnitServiceException('Could not find unit for this sport', Response::HTTP_NOT_FOUND);
    }
}
