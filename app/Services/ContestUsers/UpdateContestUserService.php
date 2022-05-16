<?php

namespace App\Services\ContestUsers;

use App\Calculators\PrizeBankCalculator;
use App\Models\Contests\ContestUser;
use App\Repositories\ContestUserRepository;
use App\Repositories\ContestUserUnitRepository;
use App\Services\SitePreferenceService;
use Illuminate\Support\Facades\DB;

class UpdateContestUserService
{
    public function __construct(
        private readonly ContestUserRepository $contestUserRepository,
        private readonly ContestUserUnitRepository $contestUserUnitRepository,
        private readonly SitePreferenceService $sitePreferenceService,
        private readonly PrizeBankCalculator $prizeBankCalculator
    ) {
    }

    public function handle(ContestUser $contestUser, int $userId, array $units): void
    {
        DB::beginTransaction();

        try {
            $this->createContestUserUnitsService->handle($contestUser->id, $units);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }
}
