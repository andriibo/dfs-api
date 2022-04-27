<?php

namespace App\Services;

use App\Calculators\PrizePlaceCalculator;
use App\Enums\SportIdEnum;
use App\Helpers\ContestHelper;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use App\Repositories\ContestRepository;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

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

    public function getGameSchedules(Contest $contest): Collection
    {
        $sportId = $contest->league->sport_id;
        if ($sportId == SportIdEnum::soccer->value) {
            return $contest->soccerGameSchedules;
        }

        if ($sportId == SportIdEnum::cricket->value) {
            return $contest->cricketGameSchedules;
        }

        throw new \Exception('Could not find schedule for this sport', Response::HTTP_NOT_FOUND);
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
        $contestUsers = collect();
        /*
         * If current contest has a status STATUS_FINISHED or STATUS_CLOSED,
         * show a list of winners near a place.
         * To do this need to get a list of participants and assign their names to appropriate places.
         */
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
