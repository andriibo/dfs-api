<?php

namespace App\Http\Collections;

use App\Http\Resources\Contests\ContestResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     title="ContestCollection",
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ContestResource")),
 *     @OA\Property(property="links", ref="#/components/schemas/PaginationSchemaOA/properties/links"),
 *     @OA\Property(property="meta", ref="#/components/schemas/PaginationSchemaOA/properties/meta")
 * )
 */
class ContestCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => ContestResource::collection($this->collection),
        ];
    }
}
