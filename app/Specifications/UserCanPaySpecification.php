<?php

namespace App\Specifications;

use Illuminate\Contracts\Auth\Authenticatable;

class UserCanPaySpecification
{
    public function isSatisfiedBy(Authenticatable $user, float $amount): bool
    {
        return ($user->balance - $amount) >= 0;
    }
}
