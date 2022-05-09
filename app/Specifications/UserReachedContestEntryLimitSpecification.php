<?php

namespace App\Specifications;

use App\Models\Contests\Contest;
use App\Repositories\ContestUserRepository;

class UserReachedContestEntryLimitSpecification
{
    public function __construct(private readonly ContestUserRepository $contestUserRepository)
    {
    }

    public function isSatisfiedBy(Contest $contest, int $userId): bool
    {
        if ($contest->entry_limit == 0) {
            return true;
        }

        $contestUsers = $this->contestUserRepository->getByParams($userId, $contest->id);

        return !($contestUsers->count() >= $contest->entry_limit);
    }
}
