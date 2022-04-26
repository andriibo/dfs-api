<?php

namespace App\Http\Resources\GameSchedules;

use App\Http\Resources\Teams\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="GameScheduleResource",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="startDate", type="integer", example="1650122541"),
 *     @OA\Property(property="awayTeamScore", type="number", format="double", example="21.16"),
 *     @OA\Property(property="homeTeamScore", type="number", format="double", example="14.71"),
 *     @OA\Property(property="awayTeam", ref="#/components/schemas/TeamResource"),
 *     @OA\Property(property="homeTeam", ref="#/components/schemas/TeamResource")
 * )
 */
class GameScheduleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'startDate' => strtotime($this->game_date),
            'awayTeamScore' => $this->away_team_score,
            'homeTeamScore' => $this->home_team_score,
            'awayTeam' => new TeamResource($this->awayTeam),
            'homeTeam' => new TeamResource($this->homeTeam),
        ];
    }
}
