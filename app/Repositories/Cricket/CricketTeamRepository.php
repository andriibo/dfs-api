<?php

namespace App\Repositories\Cricket;

use App\Models\Cricket\CricketTeam;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CricketTeamRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getTeamById(int $id): CricketTeam
    {
        return CricketTeam::findOrFail($id);
    }
}
