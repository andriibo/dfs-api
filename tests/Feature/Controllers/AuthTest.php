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
use Tests\TestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @internal
 * @coversNothing
 */
class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthRegisterEndpoint()
    {
        $data = [
            'email' => 'test@fantasysports.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'username' => 'fantasysports',
            'fullname' => 'John Doe',
        ];

        $response = $this->postJson('/api/v1/auth/register', $data);
        $response->assertCreated();
        $response->assertSee(['success', 'message']);

        $user = User::where('email', $data['email'])->first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function testAuthLoginEndpoint()
    {
        $this->createUser();

        $credentials = [
            'email' => 'test@fantasysports.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/v1/auth/login', $credentials);
        $response->assertOk();
        $response->assertSee(['success', 'data']);
        $this->assertArrayHasKey('access_token', $response->json()['data']);
    }

    public function testAuthRefreshTokenEndpoint()
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $response = $this->postJson('/api/v1/auth/refresh/token', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertSee(['success', 'data']);
        $this->assertArrayHasKey('access_token', $response->json()['data']);
    }

    public function testAuthForgotPasswordEndpoint()
    {
        $user = $this->createUser();
        $response = $this->postJson('/api/v1/auth/forgot/password', ['email' => $user->email]);
        $response->assertOk();
        $response->assertSee(['success', 'message']);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testAuthResetPasswordEndpoint()
    {
        $user = $this->createUser();
        $token = Password::broker()->createToken($user);
        $endpoint = "/api/v1/auth/reset/password?token={$token}&email={$user->email}";

        $data = [
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson($endpoint, $data);
        $response->assertOk();
        $response->assertSee(['success', 'message']);
    }

    public function testAuthEmailVerifyEndpoint()
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
        $response->assertOk();
        $response->assertSee(['success', 'message']);
    }

    public function testAuthEmailVerifyResendEndpoint()
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
        $response->assertOk();
        $response->assertSee(['success', 'message']);
    }

    public function testAuthLogoutEndpoint()
    {
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertSee(['success', 'message']);
    }

    private function getTokenForUser(JWTSubject $user): string
    {
        return JWTAuth::fromUser($user);
    }

    private function createUser(): User
    {
        return User::factory()
            ->create()
        ;
    }
}
