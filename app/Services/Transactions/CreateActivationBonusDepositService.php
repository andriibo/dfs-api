<?php

namespace App\Services\Transactions;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Repositories\UserTransactionRepository;
use App\Services\SitePreferenceService;
use App\Services\Users\UpdateBalanceService;

class CreateActivationBonusDepositService
{
    public function __construct(
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly SitePreferenceService $sitePreferenceService,
        private readonly UpdateBalanceService $updateBalanceService
    ) {
    }

    public function handle(int $userId): void
    {
        $userTransaction = $this->userTransactionRepository->getActivationBonusDepositByUserId($userId);

        if ($userTransaction) {
            return;
        }

        $activationBonusDeposit = $this->sitePreferenceService->getSettingByName('activation_bonus_deposit');

        $userTransaction = $this->userTransactionRepository->create([
            'user_id' => $userId,
            'subject_id' => $userId,
            'amount' => $activationBonusDeposit,
            'type' => TypeEnum::activationBonus,
            'status' => StatusEnum::approved,
        ]);

        if ($userTransaction) {
            $this->updateBalanceService->updateBalance($userTransaction->user, $userTransaction->amount);
        }
    }
}
