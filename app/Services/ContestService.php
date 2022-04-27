<?php

namespace App\Services;

use App\Calculators\PrizePlaceCalculator;
use App\Helpers\ContestHelper;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use App\Repositories\ContestRepository;

class ContestService
{
    public function __construct(
        private readonly ContestRepository $contestRepository,
        private readonly SitePreferenceService $sitePreferenceService
    ) {
    }

    public function getContestTypes(): array
    {
        $types = ContestHelper::getContestTypes();

        return array_map(function ($value, $label) {
            return (object) [
                'value' => $value,
                'label' => $label,
            ];
        }, array_keys($types), $types);
    }

    public function getContestById(int $contestId): Contest
    {
        return $this->contestRepository->getContestById($contestId);
    }

    public function getExpectedPayout(Contest $contest): float
    {
        $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);
        $expectedPayout = $contest->expected_payout - $contest->expected_payout / 100 * $fee;

        return round($expectedPayout, 2);
    }

    public function getMaxPrizeBank(Contest $contest): float
    {
        if (null !== $contest->custom_prize_bank || $contest->is_prize_in_percents == 0) {
            return round($contest->prize_bank, 2);
        }

        $bank = $contest->max_users * $contest->entry_fee;
        $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);

        return $bank - $bank / 100 * $fee;
    }

    /**
     * @return PrizePlace[]
     */
    public function getPrizePlaces(Contest $contest): array
    {
        $contestUsers = [];
        if ($contest->isStatusClosed()) {
            $contestUsers = $contest->contestUsers()
                ->orderBy('place')
                ->get()
            ;
        }

        $prizePlaceCalculator = new PrizePlaceCalculator();

        return $prizePlaceCalculator->handle($contest, $contestUsers);
    }
}
