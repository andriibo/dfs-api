<?php

namespace App\Repositories;

use App\Models\UserSocialAccount;

class UserSocialAccountRepository
{
    public function getAccountByParams(string $providerName, string $providerId): ?UserSocialAccount
    {
        return UserSocialAccount::query()
            ->where('provider_name', $providerName)
            ->where('provider_id', $providerId)
            ->first()
            ;
    }
}
