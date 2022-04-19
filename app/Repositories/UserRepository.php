<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getUserById(int $userId): User
    {
        return User::query()
            ->whereId($userId)
            ->firstOrFail()
            ;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getUserByEmail(string $email): User
    {
        return User::query()
            ->whereEmail($email)
            ->firstOrFail()
        ;
    }
}
