<?php

namespace App\Services;

use App\Helpers\ContestHelper;
use App\Models\Contests\Contest;
use App\Repositories\ContestRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function getContestsLobby(): Collection
    {
        return $this->contestRepository->getContestsLobby();
    }

    public function getContestsUpcoming(int $userId): Collection
    {
        return $this->contestRepository->getContestsUpcoming($userId);
    }

    public function getContestsLive(int $userId): Collection
    {
        return $this->contestRepository->getContestsUpcoming($userId);
    }

    public function getContestsHistory(int $userId): Collection
    {
        return $this->contestRepository->getContestsHistory($userId);
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
}
