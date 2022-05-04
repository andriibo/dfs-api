<?php

namespace App\Repositories;

use App\Models\Contests\ContestUser;

class ContestUserRepository
{
    public function getByParams(int $userId, int $contestId): ContestUser
    {
        return ContestUser::query()
            ->whereContestId($contestId)
            ->whereUserId($userId)
            ->first()
            ;
    }
}
