<?php

namespace App\Repositories;

use App\Enums\Contests\StatusEnum;
use App\Enums\Contests\SuspendedEnum;
use App\Filters\ContestQueryFilter;
use App\Models\Contests\Contest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContestRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getContestById(int $contestId): Contest
    {
        return Contest::findOrFail($contestId);
    }

    public function getContestsLobby(ContestQueryFilter $contestQueryFilter): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::ready)
            ->where('suspended', SuspendedEnum::no)
            ->filter($contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsUpcoming(int $userId, ContestQueryFilter $contestQueryFilter): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::ready)
            ->where('suspended', SuspendedEnum::no)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->filter($contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsLive(int $userId, ContestQueryFilter $contestQueryFilter): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::started)
            ->where('suspended', SuspendedEnum::no)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->filter($contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsHistory(int $userId, ContestQueryFilter $contestQueryFilter): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::closed)
            ->where('suspended', SuspendedEnum::no)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->filter($contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }
}
