<?php

namespace App\Services\Transactions;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Models\UserTransaction;
use App\Repositories\UserTransactionRepository;
use App\Services\SitePreferenceService;

class CreateDailyBonusDepositService
{
    public function __construct(
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly SitePreferenceService $sitePreferenceService
    ) {
    }

    /**
     * @return null|UserTransaction
     */
    public function handle(int $userId)
    {
        $userTransaction = $this->userTransactionRepository->getDailyBonusDepositByUserId($userId);

        if ($userTransaction) {
            return null;
        }

        $dailyBonusDeposit = $this->sitePreferenceService->getSettingByName('daily_bonus_deposit');

        return $this->userTransactionRepository->create([
            'user_id' => $userId,
            'amount' => $dailyBonusDeposit,
            'type' => TypeEnum::dailyBonus,
            'status' => StatusEnum::approved,
        ]);
    }
}
