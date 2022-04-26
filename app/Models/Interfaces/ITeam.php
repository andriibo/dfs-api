<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface ITeam
{
    public function league(): BelongsTo;
}
