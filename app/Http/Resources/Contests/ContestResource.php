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
 *     @OA\Property(property="contestType", type="string", enum={"fifty-fifty","head-to-head","multiplier","wta","top-three","custom"}),
 *     @OA\Property(property="expectedPayout", type="number", format="double", example="34.17"),
 *     @OA\Property(property="isPrizeInPercents", type="integer"),
 *     @OA\Property(property="maxEntries", type="integer", example="12"),
 *     @OA\Property(property="maxUsers", type="integer", example="12"),
 *     @OA\Property(property="minUsers", type="integer", example="1"),
 *     @OA\Property(property="leagueId", type="integer", example="5"),
 *     @OA\Property(property="startDate", type="integer", example="1650112441"),
 *     @OA\Property(property="endDate", type="integer", example="1650122541"),
 *     @OA\Property(property="details", type="string"),
 *     @OA\Property(property="entryFee", type="number", format="double", example="11.87"),
 *     @OA\Property(property="salaryCap", type="integer", example="7000"),
 *     @OA\Property(property="prizeBank", type="number", format="double", example="90.45"),
 *     @OA\Property(property="prizeBankType", type="integer", enum={1,2,3,5}),
 *     @OA\Property(property="customPrizeBank", type="number", format="double", example="71.23"),
 *     @OA\Property(property="maxPrizeBank", type="number", format="double", example="300.99"),
 *     @OA\Property(property="suspended", type="integer", enum={0,1}),
 *     @OA\Property(property="numEntries", type="integer", example="1"),
 *     @OA\Property(property="numUsers", type="integer", example="1"),
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
            'contestType' => $this->contest_type,
            'expectedPayout' => $contestService->getExpectedPayout($this->resource),
            'isPrizeInPercents' => $this->is_prize_in_percents,
            'maxEntries' => $this->entry_limit,
            'maxUsers' => $this->max_users,
            'minUsers' => $this->min_users,
            'leagueId' => $this->league_id,
            'startDate' => strtotime($this->start_date),
            'endDate' => strtotime($this->end_date),
            'details' => $this->details,
            'entryFee' => (float) $this->entry_fee,
            'salaryCap' => $this->salary_cap,
            'prizeBank' => (float) $this->prize_bank,
            'prizeBankType' => $this->prize_bank_type,
            'customPrizeBank' => (float) $this->custom_prize_bank,
            'maxPrizeBank' => $contestService->getMaxPrizeBank($this->resource),
            'suspended' => $this->suspended,
            'name' => $this->title,
            'numEntries' => count($this->contestUsers),
            'numUsers' => count($this->contestUsers),
            'entries' => ContestUserResource::collection($this->contestUsers),
        ];
    }
}
