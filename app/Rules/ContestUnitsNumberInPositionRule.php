<?php

namespace App\Rules;

use App\SportConfigs\AbstractSportConfig;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ContestUnitsNumberInPositionRule implements Rule
{
    private string $message;

    public function __construct(private readonly AbstractSportConfig $sportConfig)
    {
    }

    public function passes($attribute, $value): bool
    {
        foreach ($this->sportConfig->positions as $position => $positionConfig) {
            $count = $this->getCountByPosition($value, $position);

            if ($count < $positionConfig->minPlayers) {
                $this->message = sprintf($positionConfig->minPlayersError, $positionConfig->minPlayers);

                return false;
            }

            if ($count > $positionConfig->maxPlayers) {
                $this->message = sprintf($positionConfig->maxPlayersError, $positionConfig->maxPlayers);

                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }

    private function getCountByPosition(array $units, string|int $position): int
    {
        $count = 0;
        foreach ($units as $unit) {
            if ($position == Arr::get($unit, 'position')) {
                ++$count;
            }
        }

        return $count;
    }
}
