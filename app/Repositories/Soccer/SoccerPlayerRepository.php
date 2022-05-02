<?php

namespace App\Repositories\Soccer;

use App\Models\Soccer\SoccerPlayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SoccerPlayerRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getPlayerById(int $id): SoccerPlayer
    {
        return SoccerPlayer::findOrFail($id);
    }
}
