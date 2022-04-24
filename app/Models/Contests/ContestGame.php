<?php

namespace App\Models\Contests;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Contests\ContestGame.
 *
 * @property int     $contest_id
 * @property int     $game_id
 * @property Contest $contest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ContestGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestGame query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestGame whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestGame whereGameId($value)
 * @mixin Eloquent
 */
class ContestGame extends Model
{
    public $timestamps = false;

    protected $table = 'contest_game';

    protected $fillable = [
        'contest_id',
        'game_id',
    ];

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
