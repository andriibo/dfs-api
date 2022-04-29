<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function getUserByEmail(string $email): User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getUserById(int $userId): User
    {
        return $this->userRepository->getUserById($userId);
    }

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
