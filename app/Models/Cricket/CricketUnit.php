<?php

namespace App\Models\Cricket;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Cricket\CricketUnit.
 *
 * @property int                           $id
 * @property int                           $team_id
 * @property int                           $player_id
 * @property null|string                   $position
 * @property bool                          $is_active
 * @property null|string                   $salary
 * @property null|string                   $auto_salary
 * @property null|string                   $fantasy_points
 * @property null|string                   $fantasy_points_per_game
 * @property CricketPlayer                 $player
 * @property CricketTeam                   $team
 * @property null|CricketUnitStats         $totalUnitStats
 * @property Collection|CricketUnitStats[] $unitStats
 * @property null|int                      $unit_stats_count
 *
 * @method static Builder|CricketUnit newModelQuery()
 * @method static Builder|CricketUnit newQuery()
 * @method static Builder|CricketUnit query()
 * @method static Builder|CricketUnit whereAutoSalary($value)
 * @method static Builder|CricketUnit whereFantasyPoints($value)
 * @method static Builder|CricketUnit whereFantasyPointsPerGame($value)
 * @method static Builder|CricketUnit whereId($value)
 * @method static Builder|CricketUnit wherePosition($value)
 * @method static Builder|CricketUnit wherePlayerId($value)
 * @method static Builder|CricketUnit whereSalary($value)
 * @method static Builder|CricketUnit whereTeamId($value)
 * @mixin Eloquent
 */
class CricketUnit extends Model
{
    public $timestamps = false;

    protected $table = 'cricket_unit';

    protected $fillable = [
        'team_id',
        'player_id',
        'position',
        'is_active',
        'salary',
        'auto_salary',
        'fantasy_points',
        'fantasy_points_per_game',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(CricketTeam::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(CricketPlayer::class);
    }

    public function unitStats(): HasMany
    {
        return $this->hasMany(CricketUnitStats::class, 'unit_id');
    }

    public function totalUnitStats(): ?CricketUnitStats
    {
        return $this->unitStats->whereNull('game_schedule_id')->first();
    }
}
