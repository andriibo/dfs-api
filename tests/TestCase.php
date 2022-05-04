<?php

namespace Tests;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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
}
