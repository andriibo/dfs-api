<?php

namespace App\Repositories;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;
use Illuminate\Database\Eloquent\Collection;

class ContestRepository
{
    /**
     * @return Collection|Contest[]
     */
    public function getContestsLobby(): Collection
    {
        return Contest::query()
            ->whereIn('status', [StatusEnum::ready, StatusEnum::started])
            ->orderBy('start_date')
            ->get()
        ;
    }
}
