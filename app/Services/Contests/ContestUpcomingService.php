<?php

namespace App\Services\Contests;

use App\Repositories\ContestRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContestUpcomingService
{
    public function __construct(private readonly ContestRepository $contestRepository)
    {
    }

    public function handle(int $userId): LengthAwarePaginator
    {
        return $this->contestRepository->getContestsUpcoming($userId);
    }
}
