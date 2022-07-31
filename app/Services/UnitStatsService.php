<?php

namespace App\Services;

use App\Exceptions\UnitStatsServiceException;
use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketUnitStatsRepository;
use App\Repositories\Soccer\SoccerUnitStatsRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class UnitStatsService
{
    public function __construct(
        private readonly SoccerUnitStatsRepository $soccerUnitStatsRepository,
        private readonly CricketUnitStatsRepository $cricketUnitStatsRepository
    ) {
    }

    /**
     * @throws UnitStatsServiceException
     */
    public function getStats(ContestUnit $contestUnit, ?int $limit = null): Collection
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerUnitStatsRepository->getUnitStatsByUnitId($contestUnit->unit_id, $limit);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketUnitStatsRepository->getUnitStatsByUnitId($contestUnit->unit_id, $limit);
        }

        throw new UnitStatsServiceException('Could not unit stats for this sport', Response::HTTP_NOT_FOUND);
    }
}
