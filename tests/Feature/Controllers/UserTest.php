<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
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
        $this->assertProfileResponse($response);
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

    public function testUsersUpdateEndpoint(): void
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $data = [
            'email' => 'nicolas@gmail.com',
            'username' => 'nicolas',
            'dob' => '1964-01-07',
            'fullname' => 'Nicolas Cage',
        ];
        $response = $this->putJson('/api/v1/users/profile', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertProfileResponse($response);
    }

    private function assertProfileResponse(TestResponse $response): void
    {
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
}
