<?php

namespace App\Services\ContestUserUnits;

use App\Repositories\ContestUserUnitRepository;

class CreateContestUserUnitsService
{
    public function __construct(private readonly ContestUserUnitRepository $contestUserUnitRepository)
    {
    }

    public function handle(int $contestUserId, array $units): void
    {
        foreach ($units as $index => $unit) {
            $contestUnitId = $unit['id'];
            $position = $unit['position'];

            $this->contestUserUnitRepository->updateOrCreate([
                'contest_user_id' => $contestUserId,
                'contest_unit_id' => $contestUnitId,
            ], [
                'position' => $position,
                'order' => $index,
            ]);
        }
    }
}
