<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ProfileResource",
 *     @OA\Property(property="username", type="string", example="fantasysports"),
 *     @OA\Property(property="email", type="string", example="test@fantasysports.com"),
 *     @OA\Property(property="fullname", type="string", example="john Doe"),
 *     @OA\Property(property="balance", type="number", format="double", example="100.23"),
 *     @OA\Property(property="dob", type="string", nullable=true, example="1993-05-23"),
 *     @OA\Property(property="countryId", type="integer", nullable=true, example="null"),
 *     @OA\Property(property="favTeamId", type="integer", nullable=true, example="null"),
 *     @OA\Property(property="favPlayerId", type="integer", nullable=true, example="null"),
 *     @OA\Property(property="languageId", type="integer", nullable=true, example="null"),
 *     @OA\Property(property="receiveNewsletters", type="integer", enum={0,1}),
 *     @OA\Property(property="receiveNotifications", type="integer", enum={0,1}),
 *     @OA\Property(property="avatarId", type="integer", nullable=true, example="null"),
 *     @OA\Property(property="isEmailConfirmed", type="integer", enum={0,1}),
 *     @OA\Property(property="invitedByUser", type="integer", nullable=true, example="null"),
 *     @OA\Property(property="isSham", type="integer", enum={0,1}),
 *     @OA\Property(property="createdAt", type="string", example="2022-04-01 12:00:05"),
 *     @OA\Property(property="updatedAt", type="string", example="2022-04-02 11:59:41")
 * )
 */
class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'fullname' => $this->fullname,
            'balance' => $this->balance,
            'dob' => $this->dob,
            'countryId' => $this->country_id,
            'favTeamId' => $this->fav_team_id,
            'favPlayerId' => $this->fav_player_id,
            'languageId' => $this->language_id,
            'receiveNewsletters' => $this->receive_newsletters,
            'receiveNotifications' => $this->receive_notifications,
            'avatarId' => $this->avatar_id,
            'isEmailConfirmed' => $this->is_email_confirmed,
            'invitedByUser' => $this->invited_by_user,
            'isSham' => $this->is_sham,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
