<?php

namespace App\Models\Cricket;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cricket\Player.
 *
 * @property int               $id
 * @property string            $feed_type
 * @property string            $feed_id
 * @property string            $sport
 * @property string            $first_name
 * @property string            $last_name
 * @property null|string       $photo
 * @property string            $injury_status
 * @property null|string       $salary
 * @property null|string       $auto_salary
 * @property null|string       $total_fantasy_points
 * @property null|string       $total_fantasy_points_per_game
 * @property null|Carbon       $created_at
 * @property null|Carbon       $updated_at
 * @property Collection|Unit[] $units
 * @property null|int          $units_count
 *
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereAutoSalary($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereFeedId($value)
 * @method static Builder|Player whereFeedType($value)
 * @method static Builder|Player whereFirstName($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereInjuryStatus($value)
 * @method static Builder|Player whereLastName($value)
 * @method static Builder|Player wherePhoto($value)
 * @method static Builder|Player whereSalary($value)
 * @method static Builder|Player whereSport($value)
 * @method static Builder|Player whereTotalFantasyPoints($value)
 * @method static Builder|Player whereTotalFantasyPointsPerGame($value)
 * @method static Builder|Player whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Player extends Model
{
    protected $table = 'cricket_player';

    protected $fillable = [
        'feed_type',
        'feed_id',
        'sport',
        'first_name',
        'last_name',
        'photo',
        'injury_status',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
