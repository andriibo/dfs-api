<?php

namespace App\Services\ContestUserUnits;

use App\Models\Contests\ContestUser;

class CreateContestUserUnitsService
{
    public function handle(ContestUser $contestUser, array $units): void
    {
        $data = [];
        foreach ($units as $index => $unit) {
            $contestUnitId = $unit['id'];
            $position = $unit['position'];
            $data[] = [
                'contest_unit_id' => $contestUnitId,
                'position' => $position,
                'order' => $index,
            ];
        }
        $contestUser->contestUnits()->sync($data);
    }
}
