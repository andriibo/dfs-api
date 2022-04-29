<?php

namespace Tests\Feature\Controllers;

use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesUser;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class TransactionTest extends TestCase
{
    use DatabaseTransactions;
    use CreatesUser;

    private readonly UserService $userService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->userService = resolve(UserService::class);

        parent::__construct($name, $data, $dataName);
    }

    public function testTransactionsDailyBonusEndpoint(): void
    {
        $this->createUser();
        $user = $this->userService->getUserByEmail('test@fantasysports.com');
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/transactions/daily-bonus', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk();
        $response->assertSee('message');
    }
}
