<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ProfileResource",
 *     @OA\Property(property="username", type="string", example="fantasysports"),
 *     @OA\Property(property="email", type="string", example="test@fantasysports.com"),
 *     @OA\Property(property="balance", type="number", format="double", example="100.23"),
 *     @OA\Property(property="dob", type="string", nullable=true, example="1993-05-23"),
 *     @OA\Property(property="country_id", type="integer"),
 *     @OA\Property(property="fav_team_id", type="integer"),
 *     @OA\Property(property="fav_player_id", type="integer"),
 *     @OA\Property(property="language_id", type="integer"),
 *     @OA\Property(property="receive_newsletters", type="integer"),
 *     @OA\Property(property="receive_notifications", type="integer"),
 *     @OA\Property(property="avatar_id", type="integer"),
 *     @OA\Property(property="is_email_confirmed", type="integer"),
 *     @OA\Property(property="invited_by_user", type="integer"),
 *     @OA\Property(property="is_sham", type="integer"),
 *     @OA\Property(property="created_at", type="string", example="2022-04-01 12:00:05"),
 *     @OA\Property(property="updated_at", type="string", example="2022-04-02 11:59:41")
 * )
 */
class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'balance' => $this->balance,
            'dob' => $this->dob,
            'country_id' => $this->country_id,
            'fav_team_id' => $this->fav_team_id,
            'fav_player_id' => $this->fav_player_id,
            'language_id' => $this->language_id,
            'receive_newsletters' => $this->receive_newsletters,
            'receive_notifications' => $this->receive_notifications,
            'avatar_id' => $this->avatar_id,
            'is_email_confirmed' => $this->is_email_confirmed,
            'invited_by_user' => $this->invited_by_user,
            'is_sham' => $this->is_sham,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
