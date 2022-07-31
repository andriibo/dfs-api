<?php

namespace App\Services\ContestUsers;

use App\Calculators\PrizeBankCalculator;
use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Events\ContestUpdatedEvent;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Repositories\ContestUserRepository;
use App\Repositories\UserTransactionRepository;
use App\Services\ContestUserUnits\CreateContestUserUnitsService;
use App\Services\SitePreferenceService;
use App\Services\Users\UpdateBalanceService;
use Illuminate\Support\Facades\DB;

class CreateContestUserService
{
    public function __construct(
        private readonly ContestUserRepository $contestUserRepository,
        private readonly CreateContestUserUnitsService $createContestUserUnitsService,
        private readonly SitePreferenceService $sitePreferenceService,
        private readonly PrizeBankCalculator $prizeBankCalculator,
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly UpdateBalanceService $updateBalanceService
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

            $this->createContestUserUnitsService->handle($contestUser, $units);
            if ($contestUser->contest->entry_fee > 0) {
                $this->enterContestTransaction($contestUser);
            }
            $this->updatePrizeBank($contest, $contestUsersCount);
            event(new ContestUpdatedEvent($contest));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }

    private function updatePrizeBank(Contest $contest, int $contestUsersCount): void
    {
        $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);
        $prizeBank = $this->prizeBankCalculator->handle($contest, $contestUsersCount, $fee);
        $contest->prize_bank = $prizeBank;
        $contest->save();
    }

    private function enterContestTransaction(ContestUser $contestUser): void
    {
        $userTransaction = $this->userTransactionRepository->create([
            'user_id' => $contestUser->user_id,
            'subject_id' => $contestUser->id,
            'amount' => $contestUser->contest->entry_fee,
            'type' => TypeEnum::contestEnter,
            'status' => StatusEnum::success,
        ]);

        if ($userTransaction) {
            $this->updateBalanceService->updateBalance($contestUser->user, -$userTransaction->amount);
        }
    }
}
