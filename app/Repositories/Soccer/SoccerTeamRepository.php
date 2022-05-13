<?php

namespace App\Repositories\Soccer;

use App\Models\Soccer\SoccerTeam;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SoccerTeamRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getTeamById(int $id): SoccerTeam
    {
        return SoccerTeam::findOrFail($id);
    }
}
