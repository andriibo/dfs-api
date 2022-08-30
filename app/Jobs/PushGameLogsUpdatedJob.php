<?php

namespace App\Jobs;

use App\Mappers\Pusher\GameLogMapper;
use App\Models\Contests\Contest;
use App\Models\Cricket\CricketGameLog;
use App\Models\Soccer\SoccerGameLog;
use App\Services\GameLogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Pusher\Services\SendGameLogsUpdateService;

class PushGameLogsUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly Contest $contest)
    {
    }

    public function handle(): void
    {
        /* @var GameLogMapper $gameLogMapper */
        $gameLogMapper = resolve(GameLogMapper::class);
        /* @var $gameLogService GameLogService */
        $gameLogService = resolve(GameLogService::class);
        /* @var SendGameLogsUpdateService $sendGameLogsUpdateService $ */
        $sendGameLogsUpdateService = resolve(SendGameLogsUpdateService::class);
        $gameLogList = $gameLogService->getGameLogs($this->contest);
        $contestId = $this->contest->id;
        $gameLogs = [];

        array_map(function (SoccerGameLog|CricketGameLog $gameLog) use (&$gameLogs, $gameLogMapper, $contestId) {
            $gameLogs[] = $gameLogMapper->map($gameLog, $contestId);
        }, $gameLogList);

        $sendGameLogsUpdateService->handle($gameLogs, $contestId);
    }
}
