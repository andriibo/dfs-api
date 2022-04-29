<?php

namespace App\Http\Resources\ContestUnits;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestUnitResource",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="playerId", type="integer"),
 *     @OA\Property(property="totalFantasyPointsPerGame", type="number", format="double", example="11.16"),
 *     @OA\Property(property="salary", type="number", format="double", example="5000.45"),
 *     @OA\Property(property="score", type="number", format="double", example="50.45"),
 *     @OA\Property(property="fullname", type="string", example="David Olatukunbo Alaba"),
 *     @OA\Property(property="position", type="integer"),
 *     @OA\Property(property="photo", type="string"),
 *     @OA\Property(property="teamId", type="number")
 * )
 */
class ContestUnitResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'playerId' => $this->unit->player->id,
            'totalFantasyPointsPerGame' => $this->unit->player->total_fantasy_points_per_game,
            'salary' => $this->salary,
            'score' => $this->score,
            'fullname' => $this->unit->player->getFullName(),
            'position' => $this->unit->position,
            'photo' => $this->unit->player->getPhoto(),
            'teamId' => $this->team_id,
        ];
    }
}
