<?php

namespace App\Calculators;

use App\Models\Contests\Contest;

class PrizeBankCalculator
{
    use LoadPrizePlaces;

    public function handle(Contest $contest, int $contestUsersCount, int|float|string $fee): float
    {
        if (!is_null($contest->custom_prize_bank)) {
            return $contest->custom_prize_bank;
        }

        if ($contest->isPrizeBankInPercents()) {
            $bank = $contestUsersCount * $contest->entry_fee;

            return $bank - $bank / 100 * $fee;
        }

        $bank = 0;
        $prizePlaces = $this->loadPrizePlaces($contest);
        foreach ($prizePlaces as $prizePlace) {
            $bank += $prizePlace->prize;
        }

        return $bank;
    }
}
