<?php

namespace App\Rules;

use App\SportConfigs\AbstractSportConfig;
use Illuminate\Contracts\Validation\Rule;

class ContestUnitsInTeamRule implements Rule
{
    public function __construct(private readonly AbstractSportConfig $sportConfig)
    {
    }

    public function passes($attribute, $value): bool
    {
        return count($value) == $this->sportConfig->playersInTeam;
    }

    public function message(): string
    {
        return "You need to pick {$this->sportConfig->playersInTeam} players for your team.";
    }
}
