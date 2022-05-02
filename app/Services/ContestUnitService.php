<?php

namespace App\Services;

use App\Exceptions\ContestUnitServiceException;
use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketPlayerRepository;
use App\Repositories\Soccer\SoccerPlayerRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class ContestUnitService
{
    public function __construct(
        private readonly SoccerPlayerRepository $soccerPlayerRepository,
        private readonly CricketPlayerRepository $cricketPlayerRepository
    ) {
    }

    public function getUnit(ContestUnit $contestUnit): Model
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerPlayerRepository->getPlayerById($contestUnit->unit_id);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketPlayerRepository->getPlayerById($contestUnit->unit_id);
        }

        throw new ContestUnitServiceException('Could not find unit for this sport', Response::HTTP_NOT_FOUND);
    }
}
