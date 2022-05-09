<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ContestUnitsUniqueRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        $unitIds = Arr::pluck($value, 'id');
        $uniqueIds = array_unique($unitIds);

        return count($uniqueIds) == count($unitIds);
    }

    public function message(): string
    {
        return 'Each player can be picked only once.';
    }
}
