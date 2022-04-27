<?php

namespace App\Models\Soccer;

use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Soccer\SoccerGameSchedule.
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
 * @property SoccerTeam  $awayTeam
 * @property SoccerTeam  $homeTeam
 * @property League      $league
 *
 * @method static Builder|SoccerGameSchedule newModelQuery()
 * @method static Builder|SoccerGameSchedule newQuery()
 * @method static Builder|SoccerGameSchedule query()
 * @method static Builder|SoccerGameSchedule whereAwayTeamId($value)
 * @method static Builder|SoccerGameSchedule whereAwayTeamScore($value)
 * @method static Builder|SoccerGameSchedule whereDateUpdated($value)
 * @method static Builder|SoccerGameSchedule whereFeedId($value)
 * @method static Builder|SoccerGameSchedule whereFeedType($value)
 * @method static Builder|SoccerGameSchedule whereGameDate($value)
 * @method static Builder|SoccerGameSchedule whereHasFinalBox($value)
 * @method static Builder|SoccerGameSchedule whereHomeTeamId($value)
 * @method static Builder|SoccerGameSchedule whereHomeTeamScore($value)
 * @method static Builder|SoccerGameSchedule whereId($value)
 * @method static Builder|SoccerGameSchedule whereIsDataConfirmed($value)
 * @method static Builder|SoccerGameSchedule whereIsFake($value)
 * @method static Builder|SoccerGameSchedule whereIsSalaryAvailable($value)
 * @method static Builder|SoccerGameSchedule whereLatestGameLogId($value)
 * @method static Builder|SoccerGameSchedule whereLeagueId($value)
 * @method static Builder|SoccerGameSchedule whereStartingLineup($value)
 * @mixin Eloquent
 */
class SoccerGameSchedule extends Model
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
        return $this->belongsTo(SoccerTeam::class);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(SoccerTeam::class);
    }
}
