<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User.
 *
 * @property int             $id
 * @property string          $email
 * @property null|string     $email_verified_at
 * @property string          $password
 * @property null|string     $remember_token
 * @property string          $username
 * @property string          $fullname
 * @property int             $status                0 - DELETED; 1 - NO_ACTIVE; 10 - ACTIVE;
 * @property int             $parent_affiliate_id   Refers to affiliate.id
 * @property Carbon          $updated_at
 * @property Carbon          $created_at
 * @property int             $is_deleted
 * @property string          $balance
 * @property null|string     $dob
 * @property int             $country_id
 * @property int             $fav_team_id
 * @property int             $fav_player_id
 * @property int             $language_id
 * @property int             $receive_newsletters
 * @property int             $receive_notifications
 * @property int             $avatar_id
 * @property int             $is_email_confirmed
 * @property int             $invited_by_user
 * @property int             $is_sham
 * @property null|FileUpload $avatar
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatarId($value)
 * @method static Builder|User whereBalance($value)
 * @method static Builder|User whereCountryId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDob($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFavPlayerId($value)
 * @method static Builder|User whereFavTeamId($value)
 * @method static Builder|User whereFullname($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereInvitedByUser($value)
 * @method static Builder|User whereIsDeleted($value)
 * @method static Builder|User whereIsEmailConfirmed($value)
 * @method static Builder|User whereIsSham($value)
 * @method static Builder|User whereLanguageId($value)
 * @method static Builder|User whereParentAffiliateId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereReceiveNewsletters($value)
 * @method static Builder|User whereReceiveNotifications($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;
    use HasFactory;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'fullname',
        'password',
        'status',
        'parent_affiliate_id',
        'is_deleted',
        'balance',
        'dob',
        'country_id',
        'fav_team_id',
        'fav_player_id',
        'language_id',
        'receive_newsletters',
        'receive_notifications',
        'avatar_id',
        'is_email_confirmed',
        'invited_by_user',
        'is_sham',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
