<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

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
}
