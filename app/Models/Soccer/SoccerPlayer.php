<?php

namespace App\Models\Soccer;

use App\Models\FileUpload;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\Soccer\SoccerPlayerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Soccer\SoccerPlayer.
 *
 * @property int             $id
 * @property string          $feed_type
 * @property string          $feed_id
 * @property int             $sport_id
 * @property string          $first_name
 * @property string          $last_name
 * @property null|int        $photo_id
 * @property string          $injury_status
 * @property null|string     $salary
 * @property null|string     $auto_salary
 * @property null|string     $total_fantasy_points
 * @property null|string     $total_fantasy_points_per_game
 * @property null|FileUpload $photo
 *
 * @method static SoccerPlayerFactory factory(...$parameters)
 * @method static Builder|SoccerPlayer newModelQuery()
 * @method static Builder|SoccerPlayer newQuery()
 * @method static Builder|SoccerPlayer query()
 * @method static Builder|SoccerPlayer whereAutoSalary($value)
 * @method static Builder|SoccerPlayer whereFeedId($value)
 * @method static Builder|SoccerPlayer whereFeedType($value)
 * @method static Builder|SoccerPlayer whereFirstName($value)
 * @method static Builder|SoccerPlayer whereId($value)
 * @method static Builder|SoccerPlayer whereInjuryStatus($value)
 * @method static Builder|SoccerPlayer whereLastName($value)
 * @method static Builder|SoccerPlayer wherePhotoId($value)
 * @method static Builder|SoccerPlayer whereSalary($value)
 * @method static Builder|SoccerPlayer whereSportId($value)
 * @method static Builder|SoccerPlayer whereTotalFantasyPoints($value)
 * @method static Builder|SoccerPlayer whereTotalFantasyPointsPerGame($value)
 * @mixin Eloquent
 */
class SoccerPlayer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'player';

    protected $fillable = [
        'feed_type',
        'feed_id',
        'sport_id',
        'first_name',
        'last_name',
        'photo_id',
        'injury_status',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class);
    }

    public function getFullName(): string
    {
        $name = array_filter([
            $this->first_name,
            $this->last_name,
        ]);

        return implode(' ', $name);
    }
}
