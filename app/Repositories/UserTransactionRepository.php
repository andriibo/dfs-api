<?php

namespace App\Repositories;

use App\Enums\UserTransactions\TypeEnum;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserTransactionRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $userTransactionId): UserTransaction
    {
        return UserTransaction::findOrFail($userTransactionId);
    }

    public function getDailyBonusDepositByUserId(int $userId): ?UserTransaction
    {
        return UserTransaction::query()
            ->where('user_id', $userId)
            ->where('type', TypeEnum::dailyBonus)
            ->whereDate('created_at', Carbon::today())
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
        return QueryBuilder::for(UserTransaction::class)
            ->allowedFilters([
                'type',
                AllowedFilter::scope('date_start'),
                AllowedFilter::scope('date_end'),
            ])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->jsonPaginate()
            ;
    }
}
