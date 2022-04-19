<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Testing\TestResponse;
use Tests\CreatesUser;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthTest extends TestCase
{
    use DatabaseTransactions;
    use CreatesUser;

    public function testAuthRegisterEndpoint(): void
    {
        $data = [
            'email' => 'test@fantasysports.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'username' => 'fantasysports',
            'fullname' => 'John Doe',
        ];

        $response = $this->postJson('/api/v1/auth/register', $data);
        $this->assertResponse($response);

        $user = User::where('email', $data['email'])->first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function testAuthLoginEndpoint(): void
    {
        $this->createUser();

        $credentials = [
            'email' => 'test@fantasysports.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/v1/auth/login', $credentials);
        $this->assertResponseWithToken($response);
    }

    public function testAuthRefreshTokenEndpoint(): void
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $response = $this->postJson('/api/v1/auth/refresh/token', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponseWithToken($response);
    }

    public function testAuthForgotPasswordEndpoint(): void
    {
        $user = $this->createUser();
        $response = $this->postJson('/api/v1/auth/forgot/password', ['email' => $user->email]);
        $this->assertResponse($response);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testAuthResetPasswordEndpoint(): void
    {
        $user = $this->createUser();
        $token = Password::broker()->createToken($user);
        $endpoint = "/api/v1/auth/reset/password?token={$token}&email={$user->email}";

        $data = [
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson($endpoint, $data);
        $this->assertResponse($response);
    }

    public function testAuthEmailVerifyEndpoint(): void
    {
        $user = $this->createUser();
        $endpoint = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->getJson($endpoint);
        $this->assertResponse($response);
    }

    public function testAuthEmailVerifyResendEndpoint(): void
    {
        $user = $this->createUser();
        $endpoint = URL::temporarySignedRoute(
            'verification.send',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
        $response = $this->postJson($endpoint, ['email' => $user->email]);
        $this->assertResponse($response);
    }

    public function testAuthLogoutEndpoint(): void
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    private function assertResponse(TestResponse $response): void
    {
        $response->assertSuccessful();
        $response->assertSee(['success', 'message']);
        $array = $response->json();
        $this->assertIsBool($array['success']);
        $this->assertIsString($array['message']);
    }

    private function assertResponseWithToken(TestResponse $response): void
    {
        $response->assertOk();
        $response->assertSee(['success', 'data']);
        $array = $response->json();
        $this->assertIsBool($array['success']);
        $this->assertIsArray($array['data']);
        $data = $array['data'];
        $this->assertArrayHasKey('accessToken', $data);
        $this->assertArrayHasKey('tokenType', $data);
        $this->assertArrayHasKey('expiresIn', $data);
    }
}
