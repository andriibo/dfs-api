<?php

namespace App\Http\Resources\Leagues;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="PositionDetailsResource",
 *     @OA\Property(property="name", type="string", example="Goalkeeper"),
 *     @OA\Property(property="alias", type="string", example="GK"),
 *     @OA\Property(property="minPlayers", type="integer", example="1"),
 *     @OA\Property(property="maxPlayers", type="integer", example="1")
 * )
 */
class PositionDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'alias' => $this->shortName,
            'minPlayers' => $this->minPlayers,
            'maxPlayers' => $this->maxPlayers,
        ];
    }
}
