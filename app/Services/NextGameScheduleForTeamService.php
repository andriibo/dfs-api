<?php

namespace App\Services;

use App\Exceptions\NextGameScheduleForTeamServiceException;
use App\Models\Contests\Contest;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\Soccer\SoccerGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;
use App\Repositories\Soccer\SoccerGameScheduleRepository;
use Symfony\Component\HttpFoundation\Response;

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
    public function handle(Contest $contest, int $teamId): null|SoccerGameSchedule|CricketGameSchedule
    {
        if ($contest->isSportSoccer()) {
            return $this->soccerGameScheduleRepository->getNextGameSchedule($contest->id, $teamId);
        }

        if ($contest->isSportCricket()) {
            return $this->cricketGameScheduleRepository->getNextGameSchedule($contest->id, $teamId);
        }

        throw new NextGameScheduleForTeamServiceException('Could not find game schedule for this sport', Response::HTTP_NOT_FOUND);
    }
}
