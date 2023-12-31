<?php

namespace Tests\Feature\Controllers;

use App\Events\UserActivatedEvent;
use App\Events\UserOAuthActivatedEvent;
use App\Listeners\SendEmailPasswordListener;
use App\Listeners\SendEmailWelcomeListener;
use App\Listeners\UserActivatedListener;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthTest extends TestCase
{
    public function testAuthRegisterEndpoint(): void
    {
        $data = [
            'email' => 'test@fantasysports.com',
            'password' => 'password',
            'passwordConfirmation' => 'password',
            'username' => 'fantasysports',
            'fullname' => 'John Doe',
            'dob' => '1993-03-21',
        ];

        $response = $this->postJson('/api/v1/auth/register', $data);
        $this->assertResponse($response);

        $user = User::where('email', $data['email'])->first();
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function testAuthEmailVerifyEndpoint(): void
    {
        $user = User::factory()->unverified()->create();
        $endpoint = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
        Event::fake();
        Event::assertListening(UserActivatedEvent::class, UserActivatedListener::class);
        Event::assertListening(UserActivatedEvent::class, SendEmailWelcomeListener::class);
        $response = $this->getJson($endpoint);
        $this->assertResponse($response);
    }

    public function testAuthLoginEndpoint(): void
    {
        $user = $this->getVerifiedUser();

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/v1/auth/login', $credentials);
        $this->assertResponseWithToken($response);
    }

    public function testAuthRefreshTokenEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);

        $response = $this->postJson('/api/v1/auth/refresh/token', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponseWithToken($response);
    }

    public function testAuthForgotPasswordEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $response = $this->postJson('/api/v1/auth/forgot/password', ['email' => $user->email]);
        $this->assertResponse($response);

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function testAuthResetPasswordEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = Password::broker()->createToken($user);
        $endpoint = "/api/v1/auth/reset/password?token={$token}&email={$user->email}";

        $data = [
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ];
        $response = $this->postJson($endpoint, $data);
        $this->assertResponse($response);
    }

    public function testAuthEmailVerifyResendEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $response = $this->postJson('api/v1/auth/email/verify/resend', ['email' => $user->email]);
        $response->assertForbidden();
        $response->assertSee('message');
        $this->assertIsString($response['message']);
    }

    public function testAuthLogoutEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);

        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testAuthProviderEndpoint(): void
    {
        $response = $this->getJson('/api/v1/auth/google');
        $response->assertOk();
        $response->assertSee('data');
        $this->assertIsArray($response['data']);
        $data = $response['data'];
        $this->assertArrayHasKey('targetUrl', $data);
    }

    public function testAuthProviderCallbackEndpoint(): void
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods();
        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getName')
            ->andReturn(Str::random(10))
            ->shouldReceive('getEmail')
            ->andReturn(Str::random(10) . '@gmail.com')
            ->shouldReceive('getNickname')
            ->andReturn(Str::random(10))
            ->shouldReceive('getAvatar')
            ->andReturn('https://picsum.photos/200')
        ;

        $provider = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('stateless')->andReturn($provider);
        $provider->shouldReceive('user')->andReturn($abstractUser);
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        Event::fake();
        Event::assertListening(UserOAuthActivatedEvent::class, UserActivatedListener::class);
        Event::assertListening(UserOAuthActivatedEvent::class, SendEmailPasswordListener::class);
        Event::assertListening(UserOAuthActivatedEvent::class, SendEmailWelcomeListener::class);

        $response = $this->getJson('/api/v1/auth/google/callback');
        $this->assertResponseWithToken($response);
    }

    private function assertResponse(TestResponse $response): void
    {
        $response->assertSuccessful();
        $response->assertSee('message');
        $this->assertIsString($response['message']);
    }

    private function assertResponseWithToken(TestResponse $response): void
    {
        $response->assertOk();
        $response->assertSee('data');
        $this->assertIsArray($response['data']);
        $data = $response['data'];
        $this->assertArrayHasKey('accessToken', $data);
        $this->assertArrayHasKey('tokenType', $data);
        $this->assertArrayHasKey('expiresIn', $data);
    }
}
