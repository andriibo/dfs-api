<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ContestUnitsFormatRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        foreach ($value as $unit) {
            $unitId = Arr::get($unit, 'id');
            $position = Arr::get($unit, 'position');

            if (!$unitId || !$position) {
                return false;
            }

            if (!is_numeric($unitId) || !is_numeric($position)) {
                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return 'Invalid lineup format.';
    }
}
