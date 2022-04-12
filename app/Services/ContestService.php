<?php

namespace App\Services;

use App\Helpers\ContestHelper;

class ContestService
{
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
}
