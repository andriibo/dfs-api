<?php

namespace App\Repositories;

use App\Enums\Contests\StatusEnum;
use App\Enums\IsEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\League;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LeagueRepository
{
    /**
     * @return Collection|League[]
     */
    public function getListBySportId(SportIdEnum $sportIdEnum): Collection
    {
        return League::query()
            ->where('sport_id', $sportIdEnum)
            ->where('is_enabled', IsEnabledEnum::isEnabled)
            ->whereHas('contests', function (Builder $query) {
                $query->where('status', '=', StatusEnum::ready);
            })
            ->get()
        ;
    }
}