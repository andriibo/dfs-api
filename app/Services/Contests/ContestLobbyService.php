<?php

namespace App\Services\Contests;

use App\Repositories\ContestRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContestLobbyService
{
    public function __construct(private readonly ContestRepository $contestRepository)
    {
    }

    public function handle(): LengthAwarePaginator
    {
        return $this->contestRepository->getContestsLobby();
    }
}
