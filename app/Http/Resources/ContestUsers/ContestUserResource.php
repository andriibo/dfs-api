<?php

namespace App\Http\Resources\ContestUsers;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestUserResource",
 *     @OA\Property(property="id", type="integer", example="3"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="userId", type="integer", example="7"),
 *     @OA\Property(property="username", type="string", example="fantasysports"),
 *     @OA\Property(property="avatar", type="string"),
 *     @OA\Property(property="budget", type="integer", example="1350"),
 *     @OA\Property(property="date", type="integer", example="1650112441000"),
 *     @OA\Property(property="isWinner", type="integer", enum={0,1}),
 *     @OA\Property(property="place", type="integer", example="1"),
 *     @OA\Property(property="prize", type="number", format="double", example="140.56"),
 *     @OA\Property(property="score", type="number", format="double", example="23.12")
 * )
 */
class ContestUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'userId' => $this->user_id,
            'username' => $this->user->username,
            'avatar' => FileHelper::getPublicUrl($this->user->avatar),
            'budget' => $this->getBudget(),
            'date' => DateHelper::dateFormatMs($this->created_at),
            'isWinner' => $this->is_winner,
            'place' => $this->place,
            'prize' => (float) $this->prize,
            'score' => (float) $this->team_score,
        ];
    }

    private function getBudget(): float
    {
        return (float) $this->contestUnits()->sum('salary');
    }
}
