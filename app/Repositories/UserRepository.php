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

    public function getUserByEmail(string $email): ?User
    {
        return User::query()
            ->whereEmail($email)
            ->first()
        ;
    }

    public function create(array $attributes = []): User
    {
        return User::create($attributes);
    }
}
