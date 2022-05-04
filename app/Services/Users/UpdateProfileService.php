<?php

namespace App\Services\Users;

use Illuminate\Contracts\Auth\Authenticatable;

class UpdateProfileService
{
    public function handle(Authenticatable $user, array $attributes): Authenticatable
    {
        foreach ($attributes as $attribute => $value) {
            $user->setAttribute($attribute, $value);
        }

        $user->save();

        return $user;
    }
}
