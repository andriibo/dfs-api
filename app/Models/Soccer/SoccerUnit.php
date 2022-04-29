<?php

namespace App\Models\Soccer;

use App\Enums\Soccer\Units\UnitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoccerUnit extends Model
{
    protected $table = 'unit';

    protected $fillable = [
        'unit_id',
        'unit_type',
        'position',
        'salary',
        'auto_salary',
        'fantasy_points',
        'fantasy_points_per_game',
        'point_spread',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(SoccerPlayer::class, 'unit_id')
            ->where('unit_type', UnitType::player)
        ;
    }
}
