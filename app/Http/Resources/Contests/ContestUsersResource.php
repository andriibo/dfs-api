<?php

namespace App\Http\Resources\Contests;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestsUsersResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="username", type="string"),
 *     @OA\Property(property="avatar", type="string"),
 *     @OA\Property(property="budget", type="integer"),
 *     @OA\Property(property="date", type="integer"),
 *     @OA\Property(property="is_winner", type="integer"),
 *     @OA\Property(property="place", type="integer"),
 *     @OA\Property(property="prize", type="number", format="double"),
 *     @OA\Property(property="score", type="number", format="double")
 * )
 */
class ContestUsersResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => $this->user_id,
            'username' => $this->user->username,
            'avatar' => $this->user->avatar?->getFileUrl(),
            'budget' => $this->getBudget(),
            'date' => strtotime($this->created_at),
            'is_winner' => $this->is_winner,
            'place' => $this->place,
            'prize' => (float) $this->prize,
            'score' => (float) $this->team_score,
        ];
    }

    private function getBudget(): int
    {
        return (int) $this->contestUnits()->sum('salary');
    }
}
