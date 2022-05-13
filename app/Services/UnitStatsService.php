<?php

namespace App\Services;

use App\Exceptions\TeamServiceException;
use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketTeamRepository;
use App\Repositories\Soccer\SoccerUnitStatsRepository;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class UnitStatsService
{
    public function __construct(
        private readonly SoccerUnitStatsRepository $soccerUnitStatsRepository,
        private readonly CricketTeamRepository $cricketTeamRepository
    ) {
    }

    /**
     * @throws TeamServiceException
     */
    public function getStats(ContestUnit $contestUnit, ?int $limit = null): Collection
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerUnitStatsRepository->getUnitStatsByUnitId($contestUnit->unit_id, $limit);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketTeamRepository->getTeamById($contestUnit->team_id);
        }

        throw new TeamServiceException('Could not find team for this sport', Response::HTTP_NOT_FOUND);
    }
}
