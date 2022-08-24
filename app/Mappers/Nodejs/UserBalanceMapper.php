<?php

namespace App\Mappers\Nodejs;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use NodeJsClient\Dto\UserBalanceDto;

class UserBalanceMapper
{
    public function map(Authenticatable|User $user): UserBalanceDto
    {
        $userBalanceDto = new UserBalanceDto();

        $userBalanceDto->balance = $user->balance;

        return $userBalanceDto;
    }
}
