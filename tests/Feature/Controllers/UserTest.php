<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesUser;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    use DatabaseTransactions;
    use CreatesUser;

    public function testProfileEndpoint(): void
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $response = $this->getJson('/api/v1/users/profile', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'username',
                'email',
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
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testBalanceEndpoint(): void
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $response = $this->getJson('/api/v1/users/balance', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['balance'],
        ]);
    }
}
