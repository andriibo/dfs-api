<?php

namespace App\Http\Resources\ContestUnits;

use App\Helpers\FileHelper;
use App\Http\Resources\Leagues\PositionResource;
use App\Services\UnitService;
use FantasySports\SportConfig\Factories\SportConfigFactory;
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
 *     @OA\Property(property="photo", type="string"),
 *     @OA\Property(property="teamId", type="number", example="34"),
 *     @OA\Property(property="sportId", type="integer", enum={1,2,3}, description="1 - Soccer, 2- Football, 3 - Cricket"),
 *     @OA\Property(property="position", ref="#/components/schemas/PositionResource")
 * )
 */
class ContestUnitResource extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $unitService UnitService */
        $unitService = resolve(UnitService::class);
        $unit = $unitService->getUnit($this->resource);
        $sportConfig = SportConfigFactory::getConfig($this->sport_id);

        return [
            'id' => $this->id,
            'playerId' => $unit->player->id,
            'totalFantasyPointsPerGame' => (float) $unit->player->total_fantasy_points_per_game,
            'salary' => (float) $this->salary,
            'score' => (float) $this->score,
            'fullname' => $unit->player->getFullName(),
            'photo' => FileHelper::getPublicUrl($unit->player->photo),
            'teamId' => $this->team_id,
            'sportId' => $this->sport_id,
            'position' => new PositionResource($sportConfig->positions[$unit->position] ?? null),
        ];
    }
}
