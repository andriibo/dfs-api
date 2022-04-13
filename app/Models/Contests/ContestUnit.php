<?php

namespace App\Models\Contests;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Contests\ContestUnit.
 *
 * @property int         $id
 * @property int         $contest_id
 * @property int         $unit_id
 * @property int         $team_id
 * @property null|string $salary
 * @property null|string $fantasy_points_per_game
 * @property null|string $fantasy_points
 * @property null|string $point_spread
 * @property string      $score
 * @property null|int    $starting_position
 * @property string      $injury_status
 * @property Contest     $contest
 *
 * @method static Builder|ContestUnit newModelQuery()
 * @method static Builder|ContestUnit newQuery()
 * @method static Builder|ContestUnit query()
 * @method static Builder|ContestUnit whereContestId($value)
 * @method static Builder|ContestUnit whereFantasyPoints($value)
 * @method static Builder|ContestUnit whereFantasyPointsPerGame($value)
 * @method static Builder|ContestUnit whereId($value)
 * @method static Builder|ContestUnit whereInjuryStatus($value)
 * @method static Builder|ContestUnit wherePointSpread($value)
 * @method static Builder|ContestUnit whereSalary($value)
 * @method static Builder|ContestUnit whereScore($value)
 * @method static Builder|ContestUnit whereStartingPosition($value)
 * @method static Builder|ContestUnit whereTeamId($value)
 * @method static Builder|ContestUnit whereUnitId($value)
 * @mixin Eloquent
 */
class ContestUnit extends Model
{
    public $timestamps = false;

    protected $table = 'contest_unit';

    protected $fillable = [
        'contest_id',
        'unit_id',
        'team_id',
        'salary',
        'fantasy_points_per_game',
        'fantasy_points',
        'point_spread',
        'score',
        'starting_position',
        'injury_status',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
