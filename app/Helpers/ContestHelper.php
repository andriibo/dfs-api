<?php

namespace App\Helpers;

use App\Enums\Contests\ContestTypeEnum;
use App\Enums\Contests\PrizeBankTypeEnum;
use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;

class ContestHelper
{
    public static function getContestTypes(): array
    {
        return [
            ContestTypeEnum::wta->value => 'Featured',
            ContestTypeEnum::topThree->value => 'Top Three',
            ContestTypeEnum::fiftyFifty->value => '50/50',
            ContestTypeEnum::headToHead->value => 'H2H',
            ContestTypeEnum::custom->value => 'Custom',
        ];
    }

    public static function getPrizePlaces(Contest $contest): array
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

        $normalizePrizePlaces = self::normalizePrizePlaces($contest);
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

    private static function normalizePrizePlaces(Contest $contest): array
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
            case PrizeBankTypeEnum::bankTypeTopThree->value:
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

            case PrizeBankTypeEnum::bankTypeFiftyFifty->value:
                if (isset($prizes[0])) {
                    $places = $contest->contestUsers()->max('place');
                    $prizes[0]['places'] = $places > 1 ? floor($places / 2) : $places;
                }

                break;
        }

        return $prizes;
    }
}
