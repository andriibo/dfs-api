<?php

namespace App\Repositories;

use App\Enums\Contests\StatusEnum;
use App\Enums\Contests\SuspendedEnum;
use App\Filters\ContestQueryFilter;
use App\Models\Contests\Contest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContestRepository
{
    public function __construct(private readonly ContestQueryFilter $contestQueryFilter)
    {
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getContestById(int $contestId): Contest
    {
        return Contest::findOrFail($contestId);
    }

    public function getContestsLobby(): LengthAwarePaginator
    {
        return QueryBuilder::for(Contest::class)
            ->where('status', StatusEnum::ready)
            ->where('suspended', SuspendedEnum::no)
            ->allowedFilters([
                AllowedFilter::scope('leagueId'),
                AllowedFilter::scope('contestType'),
                AllowedFilter::scope('sportId'),
                AllowedFilter::scope('entryFee'),
            ])
            ->filter($this->contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsUpcoming(int $userId): LengthAwarePaginator
    {
        return QueryBuilder::for(Contest::class)
            ->where('status', StatusEnum::ready)
            ->where('suspended', SuspendedEnum::no)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->allowedFilters([
                AllowedFilter::scope('leagueId'),
                AllowedFilter::scope('contestType'),
                AllowedFilter::scope('sportId'),
                AllowedFilter::scope('entryFee'),
            ])
            ->filter($this->contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsLive(int $userId): LengthAwarePaginator
    {
        return QueryBuilder::for(Contest::class)
            ->where('status', StatusEnum::started)
            ->where('suspended', SuspendedEnum::no)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->allowedFilters([
                AllowedFilter::scope('leagueId'),
                AllowedFilter::scope('contestType'),
                AllowedFilter::scope('sportId'),
                AllowedFilter::scope('entryFee'),
            ])
            ->filter($this->contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }

    public function getContestsHistory(int $userId): LengthAwarePaginator
    {
        return QueryBuilder::for(Contest::class)
            ->whereIn('status', [StatusEnum::closed, StatusEnum::finished])
            ->where('suspended', SuspendedEnum::no)
            ->whereHas('contestUsers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->allowedFilters([
                AllowedFilter::scope('leagueId'),
                AllowedFilter::scope('contestType'),
                AllowedFilter::scope('sportId'),
                AllowedFilter::scope('entryFee'),
            ])
            ->filter($this->contestQueryFilter)
            ->orderBy('start_date')
            ->jsonPaginate()
        ;
    }
}
