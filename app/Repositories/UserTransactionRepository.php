<?php

namespace App\Repositories;

use App\Models\UserTransaction;
use Carbon\Carbon;

class UserTransactionRepository
{
    public function getDailyBonusDepositByUserId(int $userId): ?UserTransaction
    {
        return UserTransaction::query()
            ->where('user_id', $userId)
            ->where('created_at', Carbon::today())
            ->first()
            ;
    }

    public function create(array $attributes = []): UserTransaction
    {
        return UserTransaction::create($attributes);
    }
}
