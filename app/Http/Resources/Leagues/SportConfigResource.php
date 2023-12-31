<?php

namespace App\Http\Resources\Leagues;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="SportConfigResource",
 *     @OA\Property(property="playersInTeam", type="integer", example="11"),
 *     @OA\Property(property="positions", type="array", @OA\Items(ref="#/components/schemas/PositionDetailsResource"))
 * )
 */
class SportConfigResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'playersInTeam' => $this->playersInTeam,
            'positions' => PositionDetailsResource::collection(array_values($this->positions)),
        ];
    }
}
