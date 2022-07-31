<?php

namespace App\Services;

use App\Exceptions\TeamServiceException;
use App\Models\Contests\ContestUnit;
use App\Models\Cricket\CricketTeam;
use App\Models\Soccer\SoccerTeam;
use App\Repositories\Cricket\CricketTeamRepository;
use App\Repositories\Soccer\SoccerTeamRepository;
use Illuminate\Http\Response;

class TeamService
{
    public function __construct(
        private readonly SoccerTeamRepository $soccerTeamRepository,
        private readonly CricketTeamRepository $cricketTeamRepository
    ) {
    }

    /**
     * @throws TeamServiceException
     */
    public function getTeam(ContestUnit $contestUnit): CricketTeam|SoccerTeam
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerTeamRepository->getTeamById($contestUnit->team_id);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketTeamRepository->getTeamById($contestUnit->team_id);
        }

        throw new TeamServiceException('Could not find team for this sport', Response::HTTP_NOT_FOUND);
    }
}
