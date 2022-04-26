<?php

namespace App\Models\Cricket;

use App\Models\Interfaces\IGameSchedule;
use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cricket\GameSchedule.
 *
 * @property int         $id
 * @property string      $feed_id
 * @property int         $league_id
 * @property int         $home_team_id
 * @property int         $away_team_id
 * @property string      $game_date
 * @property int         $has_final_box
 * @property int         $is_data_confirmed
 * @property string      $home_team_score
 * @property string      $away_team_score
 * @property int         $is_fake
 * @property int         $is_salary_available
 * @property string      $feed_type
 * @property null|string $status
 * @property string      $type
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 * @property League      $league
 * @property Team        $homeTeam
 * @property Team        $awayTeam
 *
 * @method static Builder|GameSchedule newModelQuery()
 * @method static Builder|GameSchedule newQuery()
 * @method static Builder|GameSchedule query()
 * @method static Builder|GameSchedule whereAwayTeamId($value)
 * @method static Builder|GameSchedule whereAwayTeamScore($value)
 * @method static Builder|GameSchedule whereCreatedAt($value)
 * @method static Builder|GameSchedule whereFeedId($value)
 * @method static Builder|GameSchedule whereFeedType($value)
 * @method static Builder|GameSchedule whereGameDate($value)
 * @method static Builder|GameSchedule whereHasFinalBox($value)
 * @method static Builder|GameSchedule whereHomeTeamId($value)
 * @method static Builder|GameSchedule whereHomeTeamScore($value)
 * @method static Builder|GameSchedule whereId($value)
 * @method static Builder|GameSchedule whereIsDataConfirmed($value)
 * @method static Builder|GameSchedule whereIsFake($value)
 * @method static Builder|GameSchedule whereIsSalaryAvailable($value)
 * @method static Builder|GameSchedule whereLeagueId($value)
 * @method static Builder|GameSchedule whereStatus($value)
 * @method static Builder|GameSchedule whereType($value)
 * @method static Builder|GameSchedule whereUpdatedAt($value)
 * @mixin Eloquent
 */
class GameSchedule extends Model implements IGameSchedule
{
    protected $table = 'cricket_game_schedule';

    protected $fillable = [
        'feed_id',
        'league_id',
        'home_team_id',
        'away_team_id',
        'game_date',
        'has_final_box',
        'is_data_confirmed',
        'home_team_score',
        'away_team_score',
        'is_fake',
        'is_salary_available',
        'feed_type',
        'status',
        'type',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
