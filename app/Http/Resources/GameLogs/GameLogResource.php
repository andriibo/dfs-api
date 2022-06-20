<?php

namespace App\Http\Resources\GameLogs;

use App\Helpers\ActionPointHelper;
use App\Services\GetContestActionPointService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="GameLogResource",
 *     @OA\Property(property="playerId", type="integer", example="321"),
 *     @OA\Property(property="playerName", type="string", example="Malang Sarr"),
 *     @OA\Property(property="score", type="number", format="double", example="14.17"),
 *     @OA\Property(property="message", type="string")
 * )
 */
class GameLogResource extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $getContestActionPointService GetContestActionPointService */
        $getContestActionPointService = resolve(GetContestActionPointService::class);
        $contestId = $request->route('id');
        $actionPoint = $getContestActionPointService->handle($contestId, $this->action_point_id);

        return [
            'playerId' => $this->unit->player->id,
            'playerName' => $this->unit->player->getFullName(),
            'score' => ActionPointHelper::getScore($this->value, $actionPoint->values, $this->unit->position),
            'message' => $actionPoint->game_log_template,
        ];
    }
}
