<?php

namespace App\Http\Resources\ActionPoints;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ActionPointResource",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string", example="goal"),
 *     @OA\Property(property="sportId", type="integer", enum={1,2,3}),
 *     @OA\Property(property="alias", type="string", example="G"),
 *     @OA\Property(property="gameLogTemplate", type="string", example="Goal"),
 *     @OA\Property(property="values", type="object", example={"1":"10","2":"7","3":"30","4":"4"})
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
