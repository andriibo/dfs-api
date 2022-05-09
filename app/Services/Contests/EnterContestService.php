<?php

namespace App\Services\Contests;

use App\Calculators\PrizeBankCalculator;
use App\Models\Contests\Contest;
use App\Repositories\ContestUserRepository;
use App\Repositories\ContestUserUnitRepository;
use App\Services\SitePreferenceService;
use Illuminate\Support\Facades\DB;

class EnterContestService
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
            $contestUser = $this->contestUserRepository->create([
                'contest_id' => $contest->id,
                'user_id' => $userId,
                'title' => '#' . $contest->contestUsers()->count() + 1,
            ]);

            $this->createContestUserUnits($contestUser->id, $units);
            $this->updatePrizeBank($contest);
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

    private function updatePrizeBank(Contest $contest): void
    {
        $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);
        $prizeBank = $this->prizeBankCalculator->handle($contest, $contest->contestUsers()->count(), $fee);
        $contest->prize_bank = $prizeBank;
        $contest->save();
    }
}
