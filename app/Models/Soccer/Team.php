<?php

namespace App\Models\Soccer;

use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Soccer\Team.
 *
 * @property int    $id
 * @property string $feed_id
 * @property int    $league_id
 * @property string $name
 * @property string $nickname
 * @property string $alias
 * @property int    $country_id
 * @property int    $logo_id
 * @property string $feed_type
 * @property League $league
 *
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereAlias($value)
 * @method static Builder|Team whereCountryId($value)
 * @method static Builder|Team whereFeedId($value)
 * @method static Builder|Team whereFeedType($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereLeagueId($value)
 * @method static Builder|Team whereLogoId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereNickname($value)
 * @mixin Eloquent
 */
class Team extends Model
{
    protected $table = 'team';

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

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
}
