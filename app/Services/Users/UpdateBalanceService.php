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
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative');
        }

        $user->balance += $amount;

        return $user->save();
    }
}
