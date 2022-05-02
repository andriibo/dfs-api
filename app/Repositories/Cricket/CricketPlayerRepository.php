<?php

namespace App\Repositories\Cricket;

use App\Models\Cricket\CricketPlayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CricketPlayerRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getPlayerById(int $id): CricketPlayer
    {
        return CricketPlayer::findOrFail($id);
    }
}
