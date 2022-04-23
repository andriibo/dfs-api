<?php

namespace App\Http\Resources\ActionPoints;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ActionPointResource",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="sportId", type="integer", enum={1,2,3}),
 *     @OA\Property(property="alias", type="string"),
 *     @OA\Property(property="gameLogTemplate", type="string"),
 *     @OA\Property(property="values", type="object")
 * )
 */
class ActionPointResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sportId' => $this->sport_id,
            'alias' => $this->alias,
            'gameLogTemplate' => $this->game_log_template,
            'values' => json_decode($this->values),
        ];
    }
}
