<?php

namespace App\Models\Soccer;

use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Soccer\GameSchedule.
 *
 * @property int         $id
 * @property string      $feed_id
 * @property int         $league_id
 * @property int         $home_team_id
 * @property int         $away_team_id
 * @property string      $game_date
 * @property int         $has_final_box
 * @property int         $is_data_confirmed
 * @property int         $home_team_score
 * @property int         $away_team_score
 * @property string      $date_updated
 * @property int         $is_fake
 * @property int         $is_salary_available
 * @property null|string $starting_lineup
 * @property string      $feed_type
 * @property int         $latest_game_log_id
 * @property Team        $awayTeam
 * @property Team        $homeTeam
 * @property League      $league
 *
 * @method static Builder|GameSchedule newModelQuery()
 * @method static Builder|GameSchedule newQuery()
 * @method static Builder|GameSchedule query()
 * @method static Builder|GameSchedule whereAwayTeamId($value)
 * @method static Builder|GameSchedule whereAwayTeamScore($value)
 * @method static Builder|GameSchedule whereDateUpdated($value)
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
 * @method static Builder|GameSchedule whereLatestGameLogId($value)
 * @method static Builder|GameSchedule whereLeagueId($value)
 * @method static Builder|GameSchedule whereStartingLineup($value)
 * @mixin Eloquent
 */
class GameSchedule extends Model
{
    public $timestamps = false;
    protected $table = 'game_schedule';

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
        'date_updated',
        'is_fake',
        'is_salary_available',
        'starting_lineup',
        'feed_type',
        'latest_game_log_id',
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
