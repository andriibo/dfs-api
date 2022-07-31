<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserSocialAccount.
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $provider_name
 * @property string      $provider_id
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 * @property User        $user
 *
 * @method static Builder|UserSocialAccount newModelQuery()
 * @method static Builder|UserSocialAccount newQuery()
 * @method static Builder|UserSocialAccount query()
 * @method static Builder|UserSocialAccount whereCreatedAt($value)
 * @method static Builder|UserSocialAccount whereId($value)
 * @method static Builder|UserSocialAccount whereProviderId($value)
 * @method static Builder|UserSocialAccount whereProviderName($value)
 * @method static Builder|UserSocialAccount whereUpdatedAt($value)
 * @method static Builder|UserSocialAccount whereUserId($value)
 * @mixin Eloquent
 */
class UserSocialAccount extends Model
{
    protected $table = 'user_social_accounts';

    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
