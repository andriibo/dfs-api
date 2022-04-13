<?php

namespace App\Http\Resources\Contests;

use App\Services\ContestService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestsLobbyResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="status", type="integer"),
 *     @OA\Property(property="type", type="string"),
 *     @OA\Property(property="contest_type", type="string"),
 *     @OA\Property(property="expected_payout", type="number", format="double"),
 *     @OA\Property(property="is_prize_in_percents", type="integer"),
 *     @OA\Property(property="max_entries", type="integer"),
 *     @OA\Property(property="max_users", type="integer"),
 *     @OA\Property(property="min_users", type="integer"),
 *     @OA\Property(property="league_id", type="integer"),
 *     @OA\Property(property="start_date", type="integer"),
 *     @OA\Property(property="end_date", type="integer"),
 *     @OA\Property(property="details", type="string"),
 *     @OA\Property(property="entry_fee", type="number", format="double"),
 *     @OA\Property(property="salary_cap", type="integer"),
 *     @OA\Property(property="prize_bank", type="number", format="double"),
 *     @OA\Property(property="prize_bank_type", type="integer"),
 *     @OA\Property(property="custom_prize_bank", type="number", format="double"),
 *     @OA\Property(property="max_prize_bank", type="number", format="double"),
 *     @OA\Property(property="suspended", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="num_entries", type="integer"),
 *     @OA\Property(property="num_users", type="integer"),
 *     @OA\Property(property="entries", type="array", @OA\Items(ref="#/components/schemas/ContestUsersResource"))
 * )
 */
class ContestsLobbyResource extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $contestService ContestService */
        $contestService = resolve(ContestService::class);

        return [
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'contest_type' => $this->contest_type,
            'expected_payout' => $contestService->getExpectedPayout($this->resource),
            'is_prize_in_percents' => $this->is_prize_in_percents,
            'max_entries' => $this->entry_limit,
            'max_users' => $this->max_users,
            'min_users' => $this->min_users,
            'league_id' => $this->league_id,
            'start_date' => strtotime($this->start_date),
            'end_date' => strtotime($this->end_date),
            'details' => $this->details,
            'entry_fee' => (float) $this->entry_fee,
            'salary_cap' => $this->salary_cap,
            'prize_bank' => (float) $this->prize_bank,
            'prize_bank_type' => $this->prize_bank_type,
            'custom_prize_bank' => (float) $this->custom_prize_bank,
            'max_prize_bank' => $contestService->getMaxPrizeBank($this->resource),
            'suspended' => $this->suspended,
            'name' => $this->title,
            'num_entries' => count($this->contestUsers),
            'num_users' => count($this->contestUsers),
            'entries' => ContestUsersResource::collection($this->contestUsers),
        ];
    }
}
