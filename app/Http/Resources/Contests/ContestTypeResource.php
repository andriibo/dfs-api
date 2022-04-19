<?php

namespace App\Http\Resources\Contests;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestTypeResource",
 *     type="object",
 *     @OA\Property(property="value", type="string", enum={"wta","top-three","fifty-fifty","head-to-head","custom"}),
 *     @OA\Property(property="label", type="string", enum={"Featured","Top Three","50/50","H2H","Custom"})
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
