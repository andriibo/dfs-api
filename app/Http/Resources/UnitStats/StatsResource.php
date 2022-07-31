<?php

namespace App\Http\Resources\UnitStats;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="StatsResource",
 *     @OA\Property(property="alias", type="string", example="GP"),
 *     @OA\Property(property="title", type="string", example="Games Played"),
 *     @OA\Property(property="value", type="integer", example="9")
 * )
 */
class StatsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'alias' => $this->alias,
            'title' => $this->title,
            'value' => $this->value,
        ];
    }
}
