<?php

namespace App\Http\Resources\Contests;

use App\Services\ContestService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestResource",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string", example="Test Contest"),
 *     @OA\Property(property="status", type="integer", enum={1,2,3,4,5}),
 *     @OA\Property(property="type", type="string", enum={"admin","user","template"}),
 *     @OA\Property(property="contest_type", type="string", enum={"fifty-fifty","head-to-head","multiplier","wta","top-three","custom"}),
 *     @OA\Property(property="expected_payout", type="number", format="double", example="34.17"),
 *     @OA\Property(property="is_prize_in_percents", type="integer"),
 *     @OA\Property(property="max_entries", type="integer", example="12"),
 *     @OA\Property(property="max_users", type="integer", example="12"),
 *     @OA\Property(property="min_users", type="integer", example="1"),
 *     @OA\Property(property="league_id", type="integer", example="5"),
 *     @OA\Property(property="start_date", type="integer", example="1650112441"),
 *     @OA\Property(property="end_date", type="integer", example="1650122541"),
 *     @OA\Property(property="details", type="string"),
 *     @OA\Property(property="entry_fee", type="number", format="double", example="11.87"),
 *     @OA\Property(property="salary_cap", type="integer", example="7000"),
 *     @OA\Property(property="prize_bank", type="number", format="double", example="90.45"),
 *     @OA\Property(property="prize_bank_type", type="integer", enum={1,2,3,5}),
 *     @OA\Property(property="custom_prize_bank", type="number", format="double", example="71.23"),
 *     @OA\Property(property="max_prize_bank", type="number", format="double", example="300.99"),
 *     @OA\Property(property="suspended", type="integer", enum={0,1}),
 *     @OA\Property(property="num_entries", type="integer", example="1"),
 *     @OA\Property(property="num_users", type="integer", example="1"),
 *     @OA\Property(property="entries", type="array", @OA\Items(ref="#/components/schemas/ContestUserResource"))
 * )
 */
class ContestResource extends JsonResource
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
            'entries' => ContestUserResource::collection($this->contestUsers),
        ];
    }
}
