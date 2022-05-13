<?php

namespace App\Models\Cricket;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cricket\CricketUnitStats.
 *
 * @property int                      $id
 * @property null|int                 $game_schedule_id
 * @property int                      $player_id
 * @property null|int                 $team_id
 * @property array                    $raw_stats
 * @property null|Carbon              $created_at
 * @property null|Carbon              $updated_at
 * @property null|CricketGameSchedule $gameSchedule
 * @property null|CricketTeam         $team
 * @property CricketUnit              $unit
 *
 * @method static Builder|CricketUnitStats newModelQuery()
 * @method static Builder|CricketUnitStats newQuery()
 * @method static Builder|CricketUnitStats query()
 * @method static Builder|CricketUnitStats whereCreatedAt($value)
 * @method static Builder|CricketUnitStats whereGameScheduleId($value)
 * @method static Builder|CricketUnitStats whereId($value)
 * @method static Builder|CricketUnitStats wherePlayerId($value)
 * @method static Builder|CricketUnitStats whereRawStats($value)
 * @method static Builder|CricketUnitStats whereTeamId($value)
 * @method static Builder|CricketUnitStats whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CricketUnitStats extends Model
{
    protected $table = 'cricket_unit_stats';

    protected $fillable = [
        'game_schedule_id',
        'unit_id',
        'team_id',
        'raw_stats',
    ];

    protected $casts = [
        'raw_stats' => 'array',
    ];

    public function gameSchedule(): BelongsTo
    {
        return $this->belongsTo(CricketGameSchedule::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CricketUnit::class, 'player_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class, 'team_id');
    }
}
