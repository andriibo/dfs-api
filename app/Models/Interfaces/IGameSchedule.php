<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface IGameSchedule
{
    public function league(): BelongsTo;

    public function homeTeam(): BelongsTo;

    public function awayTeam(): BelongsTo;
}
