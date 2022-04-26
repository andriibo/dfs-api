<?php

namespace App\Models\Cricket;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Cricket\Unit.
 *
 * @property int         $id
 * @property int         $team_id
 * @property int         $player_id
 * @property null|string $position
 * @property null|string $salary
 * @property null|string $auto_salary
 * @property null|string $total_fantasy_points
 * @property null|string $total_fantasy_points_per_game
 * @property Player      $player
 * @property Team        $team
 *
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereAutoSalary($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit wherePosition($value)
 * @method static Builder|Unit wherePlayerId($value)
 * @method static Builder|Unit whereSalary($value)
 * @method static Builder|Unit whereTeamId($value)
 * @method static Builder|Unit whereTotalFantasyPoints($value)
 * @method static Builder|Unit whereTotalFantasyPointsPerGame($value)
 * @mixin Eloquent
 */
class Unit extends Model
{
    public $timestamps = false;

    protected $table = 'cricket_unit';

    protected $fillable = [
        'team_id',
        'player_id',
        'position',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
