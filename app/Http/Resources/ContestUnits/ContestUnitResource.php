<?php

namespace App\Http\Resources\ContestUnits;

use App\Services\UnitService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestUnitResource",
 *     @OA\Property(property="id", type="integer", example="21"),
 *     @OA\Property(property="playerId", type="integer", example="45"),
 *     @OA\Property(property="totalFantasyPointsPerGame", type="number", format="double", example="11.16"),
 *     @OA\Property(property="salary", type="number", format="double", example="5000.45"),
 *     @OA\Property(property="score", type="number", format="double", example="50.45"),
 *     @OA\Property(property="fullname", type="string", example="David Olatukunbo Alaba"),
 *     @OA\Property(property="position", type="integer", example="1"),
 *     @OA\Property(property="photo", type="string"),
 *     @OA\Property(property="teamId", type="number", example="34")
 * )
 */
class ContestUnitResource extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $unitService UnitService */
        $unitService = resolve(UnitService::class);
        $unit = $unitService->getUnit($this->resource);

        return [
            'id' => $this->id,
            'playerId' => $unit->player->id,
            'totalFantasyPointsPerGame' => $unit->player->total_fantasy_points_per_game,
            'salary' => $this->salary,
            'score' => $this->score,
            'fullname' => $unit->player->getFullName(),
            'position' => $unit->position,
            'photo' => $unit->player->photo?->getFileUrl(),
            'teamId' => $this->team_id,
        ];
    }
}
