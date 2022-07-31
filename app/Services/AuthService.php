<?php

namespace App\Services;

class AuthService
{
    public function createNewToken(string $token): array
    {
        return [
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60,
        ];
    }
}
