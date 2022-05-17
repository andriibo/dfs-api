<?php

namespace App\Repositories;

use App\Enums\UserTransactions\TypeEnum;
use App\Models\UserTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserTransactionRepository
{
    public function getDailyBonusDepositByUserId(int $userId): ?UserTransaction
    {
        return UserTransaction::query()
            ->where('user_id', $userId)
            ->where('type', TypeEnum::dailyBonus)
            ->whereDay('created_at', date('d'))
            ->first()
            ;
    }

    public function getActivationBonusDepositByUserId(int $userId): ?UserTransaction
    {
        return UserTransaction::query()
            ->where('user_id', $userId)
            ->where('type', TypeEnum::activationBonus)
            ->first()
            ;
    }

    public function create(array $attributes = []): UserTransaction
    {
        return UserTransaction::create($attributes);
    }

    public function getTransactionsByUserId(int $userId): LengthAwarePaginator
    {
        return UserTransaction::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->jsonPaginate()
            ;
    }
}
