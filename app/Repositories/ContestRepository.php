<?php

namespace App\Repositories;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ContestRepository
{
    public function getContestsLobby(): LengthAwarePaginator
    {
        return Contest::query()
            ->whereIn('status', [StatusEnum::ready, StatusEnum::started])
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsUpcoming(int $userId): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::ready)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsLive(int $userId): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::started)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsHistory(int $userId): LengthAwarePaginator
    {
        return Contest::query()
            ->where('status', StatusEnum::closed)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }
}
