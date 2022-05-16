<?php

namespace App\Services;

use App\Exceptions\NextGameScheduleForTeamServiceException;
use App\Models\Contests\ContestUnit;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\Soccer\SoccerGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;
use App\Repositories\Soccer\SoccerGameScheduleRepository;
use Illuminate\Http\Response;

class NextGameScheduleForTeamService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly SoccerGameScheduleRepository $soccerGameScheduleRepository
    ) {
    }

    /**
     * @throws NextGameScheduleForTeamServiceException
     */
    public function handle(ContestUnit $contestUnit): null|SoccerGameSchedule|CricketGameSchedule
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerGameScheduleRepository->getNextGameSchedule($contestUnit->contest_id, $contestUnit->team_id);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketGameScheduleRepository->getNextGameSchedule($contestUnit->contest_id, $contestUnit->team_id);
        }

        throw new NextGameScheduleForTeamServiceException('Could not find game schedule for this sport', Response::HTTP_NOT_FOUND);
    }
}
