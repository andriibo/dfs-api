<?php

namespace App\Services\Transactions;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Repositories\UserTransactionRepository;
use App\Services\SitePreferenceService;

class CreateActivationBonusDepositService
{
    public function __construct(
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly SitePreferenceService $sitePreferenceService
    ) {
    }

    public function handle(int $userId): void
    {
        $userTransaction = $this->userTransactionRepository->getActivationBonusDepositByUserId($userId);

        if ($userTransaction) {
            return;
        }

        $activationBonusDeposit = $this->sitePreferenceService->getSettingByName('activation_bonus_deposit');

        $this->userTransactionRepository->create([
            'user_id' => $userId,
            'amount' => $activationBonusDeposit,
            'type' => TypeEnum::activationBonus,
            'status' => StatusEnum::approved,
        ]);
    }
}
