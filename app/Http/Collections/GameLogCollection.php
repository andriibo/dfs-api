<?php

namespace App\Http\Collections;

use App\Http\Resources\GameLogs\GameLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     title="ContestCollection",
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/GameLogResource")),
 *     @OA\Property(property="links", ref="#/components/schemas/PaginationSchemaOA/properties/links"),
 *     @OA\Property(property="meta", ref="#/components/schemas/PaginationSchemaOA/properties/meta")
 * )
 */
class GameLogCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => GameLogResource::collection($this->collection),
        ];
    }
}
