<?php

namespace Tests;

use App\Models\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

trait CreatesUser
{
    protected function getTokenForUser(JWTSubject $user): string
    {
        return JWTAuth::fromUser($user);
    }

    protected function createUser(): User
    {
        return User::factory()
            ->create()
            ;
    }
}
