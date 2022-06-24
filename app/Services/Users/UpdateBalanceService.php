<?php

namespace App\Services\Users;

use App\Events\UserBalanceUpdatedEvent;
use App\Exceptions\UpdateBalanceServiceException;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateBalanceService
{
    /**
     * @throws UpdateBalanceServiceException
     */
    public function updateBalance(Authenticatable $user, float $amount): void
    {
        if (!($user->balance + $amount) < 0) {
            throw new UpdateBalanceServiceException('Balance cannot be less than 0.');
        }

        $user->balance += $amount;

        if (!$user->save()) {
            throw new UpdateBalanceServiceException('Can\'t update user balance');
        }

        event(new UserBalanceUpdatedEvent($user));
    }
}
