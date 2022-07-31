<?php

namespace App\Specifications;

use App\Repositories\ContestUserRepository;

class UserInContestSpecification
{
    public function __construct(private readonly ContestUserRepository $contestUserRepository)
    {
    }

    public function isSatisfiedBy(int $contestId, int $userId): bool
    {
        $contestUsers = $this->contestUserRepository->getByParams($userId, $contestId);

        return (bool) $contestUsers->count();
    }
}
