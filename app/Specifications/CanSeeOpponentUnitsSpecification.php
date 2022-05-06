<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\ContestUser;

class CanSeeOpponentUnitsSpecification
{
    public function isSatisfiedBy(ContestUser $entryContestUser, ContestUser $opponentContestUser): bool
    {
        if ($entryContestUser->contest_id !== $opponentContestUser->contest_id) {
            return false;
        }

        return in_array($entryContestUser->contest->status, [
            StatusEnum::started->value,
            StatusEnum::finished->value,
            StatusEnum::closed->value,
        ]);
    }
}
