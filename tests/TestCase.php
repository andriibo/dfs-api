<?php

namespace Tests;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    use CreatesApplication;

    public $mockConsoleOutput = false;

    protected readonly UserRepository $userRepository;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->userRepository = new UserRepository();

        parent::__construct($name, $data, $dataName);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    protected function getVerifiedUser(): User
    {
        return User::factory()
            ->verified()
            ->create()
            ;
    }

    protected function getTokenForUser(JWTSubject $user): string
    {
        return JWTAuth::fromUser($user);
    }
}
