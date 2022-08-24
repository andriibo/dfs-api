<?php

namespace App\Mappers\Nodejs;

use App\Helpers\ActionPointHelper;
use App\Models\Cricket\CricketGameLog;
use App\Models\Soccer\SoccerGameLog;
use App\Services\GetContestActionPointService;
use NodeJsClient\Dto\GameLogDto;

class GameLogMapper
{
    public function map(SoccerGameLog|CricketGameLog $gameLog, $contestId): GameLogDto
    {
        $gameLogDto = new GameLogDto();
        /* @var $getContestActionPointService GetContestActionPointService */
        $getContestActionPointService = resolve(GetContestActionPointService::class);
        $actionPoint = $getContestActionPointService->handle($contestId, $gameLog->action_point_id);

        $gameLogDto->playerId = $gameLog->unit->player_id;
        $gameLogDto->playerName = $gameLog->unit->player->getFullName();
        $gameLogDto->score = ActionPointHelper::getScore($gameLog->value, $actionPoint->values, $gameLog->unit->position);
        $gameLogDto->message = $actionPoint->game_log_template;

        return $gameLogDto;
    }
}
