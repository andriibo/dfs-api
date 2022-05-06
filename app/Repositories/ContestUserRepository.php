<?php

namespace App\Repositories;

use App\Models\Contests\ContestUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContestUserRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $contestUserId): ContestUser
    {
        return ContestUser::findOrFail($contestUserId);
    }

    public function getByParams(int $userId, int $contestId): ContestUser
    {
        return ContestUser::query()
            ->whereContestId($contestId)
            ->whereUserId($userId)
            ->first()
            ;
    }
}
