<?php

namespace App\Services\Contests;

use App\Repositories\ContestRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContestHistoryService
{
    public function __construct(private readonly ContestRepository $contestRepository)
    {
    }

    public function handle(int $userId): LengthAwarePaginator
    {
        return $this->contestRepository->getContestsHistory($userId);
    }
}
