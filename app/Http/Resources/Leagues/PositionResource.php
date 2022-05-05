<?php

namespace App\Http\Resources\Leagues;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="PositionResource",
 *     @OA\Property(property="name", type="string", example="Goalkeeper"),
 *     @OA\Property(property="alias", type="string", example="GK")
 * )
 */
class PositionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'alias' => $this->shortName,
        ];
    }
}
