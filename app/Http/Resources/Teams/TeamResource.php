<?php

namespace App\Http\Resources\Teams;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TeamResource",
 *     @OA\Property(property="id", type="integer", example="3"),
 *     @OA\Property(property="name", type="string", example="Watford"),
 *     @OA\Property(property="alias", type="string", example="WAT")
 * )
 */
class TeamResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
        ];
    }
}
