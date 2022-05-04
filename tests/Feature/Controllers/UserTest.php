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

    public function testUsersProfileEndpoint(): void
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
                'fullname',
                'balance',
                'dob',
                'countryId',
                'favTeamId',
                'favPlayerId',
                'languageId',
                'receiveNewsletters',
                'receiveNotifications',
                'avatarId',
                'isEmailConfirmed',
                'invitedByUser',
                'isSham',
                'createdAt',
                'updatedAt',
            ],
        ]);
    }

    public function testUsersBalanceEndpoint(): void
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
