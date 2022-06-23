<?php

namespace App\Services\Users;

use App\Events\UserBalanceUpdatedEvent;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use InvalidArgumentException;

class UpdateBalanceService
{
    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function updateBalance(Authenticatable $user, float $amount): void
    {
        if (!($user->balance + $amount) < 0) {
            throw new InvalidArgumentException('Balance cannot be less than 0.');
        }

        $user->balance += $amount;

        if (!$user->save()) {
            throw new Exception('Can\'t update user balance');
        }

        event(new UserBalanceUpdatedEvent($user->id));
    }
}
