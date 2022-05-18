<?php

namespace App\Http\Resources\Leagues;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="LeagueResource",
 *     @OA\Property(property="id", type="integer", example="3"),
 *     @OA\Property(property="name", type="string", example="England - Premier League"),
 *     @OA\Property(property="alias", type="string", example="EPL"),
 *     @OA\Property(property="sportId", type="integer", enum={1,2,3}, description="1 - Soccer, 2- Football, 3 - Cricket")
 * )
 */
class LeagueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
            'sportId' => $this->sport_id,
        ];
    }
}
