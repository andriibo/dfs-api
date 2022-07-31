<?php

namespace App\Rules;

use App\Models\Contests\Contest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ContestUnitsBelongsToContestRule implements Rule
{
    public function __construct(private readonly Contest $contest)
    {
    }

    public function passes($attribute, $value): bool
    {
        $contestUnitIds = $this->contest->contestUnits->modelKeys();
        $lineupIds = Arr::pluck($value, 'id');
        $intersect = array_intersect($contestUnitIds, $lineupIds);

        return count($intersect) == count($value);
    }

    public function message(): string
    {
        return 'Picked units do not belong to this contest.';
    }
}
