<?php

namespace App\Rules;

use App\Models\Contests\Contest;
use App\Services\UnitService;
use App\SportConfigs\AbstractSportConfig;
use Illuminate\Contracts\Validation\Rule;

class ContestUnitsPositionsRule implements Rule
{
    public function __construct(
        private readonly Contest $contest,
        private readonly AbstractSportConfig $sportConfig
    ) {
    }

    public function passes($attribute, $value): bool
    {
        $positions = $this->sportConfig->positions;
        /* @var $unitService UnitService */
        $unitService = resolve(UnitService::class);
        foreach ($value as $unit) {
            $unitId = $unit['id'];
            $position = $unit['position'];
            $contestUnit = $this->contest->contestUnits->find($unitId);
            if (!$contestUnit) {
                throw new \Exception('Unexpected unit');
            }
            $unit = $unitService->getUnit($contestUnit);
            $contestUnitPosition = $unit->position;
            $positionConfig = $positions[$contestUnitPosition];
            if (!in_array($position, $positionConfig->allowedPositions)) {
                // unit is picked for wrong position
                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return 'Invalid lineup positions.';
    }
}
