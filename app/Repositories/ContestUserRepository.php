<?php

namespace App\Repositories;

use App\Models\Contests\ContestUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class ContestUserRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $contestUserId): ContestUser
    {
        return ContestUser::findOrFail($contestUserId);
    }

    public function getByParams(int $userId, int $contestId): Collection
    {
        return ContestUser::query()
            ->whereContestId($contestId)
            ->whereUserId($userId)
            ->get()
            ;
    }

    public function create(array $attributes = []): ContestUser
    {
        return ContestUser::create($attributes);
    }
}
