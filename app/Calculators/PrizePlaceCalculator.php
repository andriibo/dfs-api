<?php

namespace App\Calculators;

use App\Enums\Contests\PrizeBankTypeEnum;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use Illuminate\Support\Collection;

class PrizePlaceCalculator
{
    use PrizePlaces;

    private array $prizePercents = [50, 30, 20];
    private int $placeFrom = 1;
    private int $placeTo = 0;

    /**
     * @return PrizePlace[]
     */
    public function handle(Contest $contest, Collection $contestUsers): array
    {
        $prizePlaces = [];
        $normalizePrizePlaces = $this->normalizePrizePlaces($contest);
        foreach ($normalizePrizePlaces as $prizePlace) {
            $normal = new PrizePlace();
            [$from, $to] = $this->calculateFromTo($prizePlace);
            $normal->from = $from;
            $normal->to = $to;
            $normal->places = $prizePlace->places;
            $normal->prize = $prizePlace->prize;

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

    /**
     * @return array<int>
     */
    private function calculateFromTo(PrizePlace $prizePlace): array
    {
        if ($prizePlace->places == 1) {
            $this->placeTo = $this->placeFrom;
            $from = $this->placeFrom;
            $to = $this->placeTo;
            ++$this->placeFrom;
        } else {
            $this->placeTo += $prizePlace->places;
            $from = $this->placeFrom;
            $to = $this->placeTo;
            $this->placeFrom = $this->placeTo + 1;
        }

        return [$from, $to];
    }

    /**
     * @return PrizePlace[]
     */
    private function normalizePrizePlaces(Contest $contest): array
    {
        $prizes = $this->handlePrizePlaces($contest);
        if ($contest->prize_bank_type == PrizeBankTypeEnum::topThree->value) {
            $topThree = [];
            foreach ($this->prizePercents as $prizePercent) {
                $prizePlace = new PrizePlace();
                $prizePlace->places = 1;
                $prizePlace->prize = round($prizePlace->prize / 100 * $prizePercent, 2);
                $prizePlace->voucher = round($prizePlace->voucher / 100 * $prizePercent, 2);
                $topThree[] = $prizePlace;
            }
            $prizes = $topThree;
        } elseif ($contest->prize_bank_type == PrizeBankTypeEnum::fiftyFifty->value && isset($prizes[0])) {
            $places = $contest->contestUsers()->max('place');
            $prizes[0]->places = $places > 1 ? floor($places / 2) : $places;
        }

        return $prizes;
    }
}
