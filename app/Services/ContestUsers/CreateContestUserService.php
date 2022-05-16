<?php

namespace App\Services\ContestUsers;

use App\Calculators\PrizeBankCalculator;
use App\Models\Contests\Contest;
use App\Repositories\ContestUserRepository;
use App\Repositories\ContestUserUnitRepository;
use App\Services\SitePreferenceService;
use Illuminate\Support\Facades\DB;

class CreateContestUserService
{
    public function __construct(
        private readonly ContestUserRepository $contestUserRepository,
        private readonly ContestUserUnitRepository $contestUserUnitRepository,
        private readonly SitePreferenceService $sitePreferenceService,
        private readonly PrizeBankCalculator $prizeBankCalculator
    ) {
    }

    public function handle(Contest $contest, int $userId, array $units): void
    {
        DB::beginTransaction();

        try {
            $contestUsersCount = $contest->contestUsers()->count();
            ++$contestUsersCount;
            $contestUser = $this->contestUserRepository->create([
                'contest_id' => $contest->id,
                'user_id' => $userId,
                'title' => '#' . $contestUsersCount,
            ]);

            $this->createContestUserUnits($contestUser->id, $units);
            $this->updatePrizeBank($contest, $contestUsersCount);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }

    private function createContestUserUnits(int $contestUserId, array $units): void
    {
        foreach ($units as $index => $unit) {
            $contestUnitId = $unit['id'];
            $position = $unit['position'];

            $this->contestUserUnitRepository->create([
                'contest_user_id' => $contestUserId,
                'contest_unit_id' => $contestUnitId,
                'position' => $position,
                'order' => $index,
            ]);
        }
    }

    private function updatePrizeBank(Contest $contest, int $contestUsersCount): void
    {
        $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);
        $prizeBank = $this->prizeBankCalculator->handle($contest, $contestUsersCount, $fee);
        $contest->prize_bank = $prizeBank;
        $contest->save();
    }
}
