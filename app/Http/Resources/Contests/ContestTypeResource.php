<?php

namespace App\Http\Resources\Contests;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestTypeResource",
 *     type="object",
 *     @OA\Property(property="value", type="string"),
 *     @OA\Property(property="label", type="string")
 * )
 */
class ContestTypeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label,
        ];
    }
}
