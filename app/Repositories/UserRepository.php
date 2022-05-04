<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getUserById(int $id): User
    {
        return User::findOrFail($id);
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
