<?php

namespace App\Http\Resources\ContestUsers;

use App\Http\Resources\ContestUnits\ContestUnitResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="OpponentUnitsResource",
 *     @OA\Property(property="userId", type="integer", example="57"),
 *     @OA\Property(property="username", type="string", example="Joe"),
 *     @OA\Property(property="budget", type="number", format="double", example="11.16"),
 *     @OA\Property(property="score", type="number", format="double", example="50.45"),
 *     @OA\Property(property="prize", type="number", format="double", example="25.15"),
 *     @OA\Property(property="title", type="string", example="Title"),
 *     @OA\Property(property="units", type="array", @OA\Items(ref="#/components/schemas/ContestUnitResource"))
 * )
 */
class OpponentUnitsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'userId' => $this->user_id,
            'username' => $this->user->username,
            'budget' => (float) $this->contestUnits()->sum('salary'),
            'score' => $this->team_score,
            'prize' => $this->prize,
            'title' => $this->title,
            'units' => ContestUnitResource::collection($this->contestUnits),
        ];
    }
}
