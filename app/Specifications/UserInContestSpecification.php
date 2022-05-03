<?php

namespace App\Specifications;

use App\Repositories\ContestUserRepository;

class UserInContestSpecification
{
    private readonly ContestUserRepository $contestUserRepository;

    public function __construct(
        private readonly int $contestId,
        private readonly int $userId
    ) {
        $this->contestUserRepository = new ContestUserRepository();
    }

    public function isSatisfiedBy(): bool
    {
        $contestUser = $this->contestUserRepository->getByParams($this->userId, $this->contestId);

        return !is_null($contestUser);
    }
}
