<?php

namespace Tests\Feature\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    public function testUsersProfileEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);

        $response = $this->getJson('/api/v1/users/profile', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertProfileResponse($response);
    }

    public function testUsersBalanceEndpoint(): void
    {
        $user = $this->getVerifiedUser();
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
        $user = $this->getVerifiedUser();
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

    public function testUsersPasswordEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $data = [
            'currentPassword' => 'password',
            'password' => 'newpassword',
            'passwordConfirmation' => 'newpassword',
        ];
        $response = $this->patchJson('/api/v1/users/password', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertSee('message');
        $this->assertIsString($response['message']);
    }

    public function testUsersAvatarEndpoint(): void
    {
        Storage::fake('avatars');
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->postJson('/api/v1/users/avatar', [
            'image' => UploadedFile::fake()->image('avatar.png'),
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertSee('message');
        $this->assertIsString($response['message']);
    }

    private function assertProfileResponse(TestResponse $response): void
    {
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
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
                'avatar',
                'isEmailConfirmed',
                'invitedByUser',
                'isSham',
                'createdAt',
                'updatedAt',
            ],
        ]);
    }
}
