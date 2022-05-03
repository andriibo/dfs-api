<?php

namespace App\Services;

use App\Exceptions\GameLogServiceException;
use App\Models\Contests\Contest;
use App\Repositories\Cricket\CricketGameLogRepository;
use App\Repositories\Soccer\SoccerGameLogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class GameLogService
{
    public function __construct(
        private readonly CricketGameLogRepository $cricketGameLogRepository,
        private readonly SoccerGameLogRepository $soccerGameLogRepository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getGameLogs(Contest $contest): LengthAwarePaginator
    {
        if ($contest->isSportSoccer()) {
            return $this->soccerGameLogRepository->getGameLogsByContestId($contest->id);
        }

        if ($contest->isSportCricket()) {
            return $this->cricketGameLogRepository->getGameLogsByContestId($contest->id);
        }

        throw new GameLogServiceException('Could not find game logs for this sport', Response::HTTP_NOT_FOUND);
    }
}
