<?php

namespace App\Services;

use App\Enums\SportIdEnum;
use App\Models\League;
use App\Repositories\LeagueRepository;
use Illuminate\Database\Eloquent\Collection;

class LeagueService
{
    public function __construct(private readonly LeagueRepository $leagueRepository)
    {
    }

    /**
     * @return Collection|League[]
     */
    public function getListBySportId(SportIdEnum $sportIdEnum): Collection
    {
        return $this->leagueRepository->getListBySportId($sportIdEnum);
    }
}
