<?php

namespace App\Models\Cricket;

use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cricket\Team.
 *
 * @property int                 $id
 * @property string              $feed_id
 * @property int                 $league_id
 * @property string              $name
 * @property string              $nickname
 * @property string              $alias
 * @property int                 $country_id
 * @property null|string         $logo
 * @property string              $feed_type
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property Collection|Player[] $players
 * @property null|int            $players_count
 * @property \App\Models\League  $league
 * @property Collection|Unit[]   $units
 * @property null|int            $units_count
 *
 * @method static Builder|Team whereAlias($value)
 * @method static Builder|Team whereCountryId($value)
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereFeedId($value)
 * @method static Builder|Team whereFeedType($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereLeagueId($value)
 * @method static Builder|Team whereLogo($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereNickname($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @mixin Eloquent
 */
class Team extends Model
{
    protected $table = 'cricket_team';

    protected $fillable = [
        'feed_id',
        'league_id',
        'name',
        'nickname',
        'alias',
        'country_id',
        'logo',
        'feed_type',
    ];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'cricket_team_player');
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
