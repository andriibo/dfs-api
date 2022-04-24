<?php

namespace App\Services;

use App\Enums\Contests\PrizeBankTypeEnum;
use App\Enums\Contests\StatusEnum;
use App\Helpers\ContestHelper;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use App\Repositories\ContestRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function getContestsLobby(): LengthAwarePaginator
    {
        return $this->contestRepository->getContestsLobby();
    }

    public function getContestsUpcoming(int $userId): LengthAwarePaginator
    {
        return $this->contestRepository->getContestsUpcoming($userId);
    }

    public function getContestsLive(int $userId): LengthAwarePaginator
    {
        return $this->contestRepository->getContestsUpcoming($userId);
    }

    public function getContestsHistory(int $userId): LengthAwarePaginator
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

    public function getPrizePlaces(Contest $contest): array
    {
        $placeFrom = 1;
        $placeTo = 0;

        /**
         * If current contest has a status STATUS_FINISHED or STATUS_CLOSED,
         * show a list of winners near a place.
         * To do this need to get a list of participants and assign their names to appropriate places.
         */
        $contestUsers = $prizePlaces = [];
        if ($contest->status == StatusEnum::closed->value) {
            $contestUsers = $contest->contestUsers()
                ->orderBy('place')
                ->get()
            ;
        }

        $normalizePrizePlaces = $this->normalizePrizePlaces($contest);
        foreach ($normalizePrizePlaces as $prizePlace) {
            $normal = new PrizePlace();
            if ($prizePlace['places'] == 1) {
                $placeTo = $placeFrom;
                $normal->from = $placeFrom;
                $normal->to = $placeTo;
                ++$placeFrom;
            } else {
                $placeTo += $prizePlace['places'];
                $normal->from = $placeFrom;
                $normal->to = $placeTo;
                $placeFrom = $placeTo + 1;
            }
            $normal->places = $prizePlace['places'];
            $normal->prize = $prizePlace['prize'];

            $winners = [];
            foreach ($contestUsers as $key => $contestUser) {
                if ($contestUser->place >= $normal->from
                    && $contestUser->place <= $normal->to) {
                    $winners[] = $contestUser;
                    unset($contestUsers[$key]);
                }
            }

            $normal->winners = $winners;
            $prizePlaces[] = $normal;
        }

        return $prizePlaces;
    }

    private function normalizePrizePlaces(Contest $contest): array
    {
        $prizePercents = [50, 30, 20];
        $prizes = [];

        foreach ($contest->prize_places as $item) {
            if ($contest->is_prize_in_percents) {
                $item['prize'] = round($contest->prize_bank / 100 * $item['prize'], 2);
                $item['voucher'] = round($contest->prize_bank / 100 * $item['voucher'], 2);
            }
            $prizes[] = $item;
        }

        switch ($contest->prize_bank_type) {
            case PrizeBankTypeEnum::topThree->value:
                $topThree = [];
                foreach ($prizePercents as $prizePercent) {
                    $prizePlace = new PrizePlace();
                    $prizePlace->places = 1;
                    $prizePlace->prize = round($prizePlace->prize / 100 * $prizePercent, 2);
                    $prizePlace->voucher = round($prizePlace->voucher / 100 * $prizePercent, 2);
                    $topThree[] = $prizePlace;
                }
                $prizes = $topThree;

                break;

            case PrizeBankTypeEnum::fiftyFifty->value:
                if (isset($prizes[0])) {
                    $places = $contest->contestUsers()->max('place');
                    $prizes[0]['places'] = $places > 1 ? floor($places / 2) : $places;
                }

                break;
        }

        return $prizes;
    }
}
