<?php

namespace App\Services\Users;

use Illuminate\Contracts\Auth\Authenticatable;

class UpdateBalanceService
{
    /**
     * @throws \InvalidArgumentException
     */
    public function updateBalance(Authenticatable $user, float $amount): bool
    {
        if (!($user->balance + $amount) < 0) {
            throw new \InvalidArgumentException('Balance cannot be less than 0.');
        }

        $user->balance += $amount;

        return $user->save();
    }
}
