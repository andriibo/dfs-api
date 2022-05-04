<?php

namespace Tests\Feature\Controllers;

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

    public function testTransactionsDailyBonusEndpoint(): void
    {
        $this->createUser();
        $user = $this->userRepository->getUserByEmail('test@fantasysports.com');
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/transactions/daily-bonus', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk();
        $response->assertSee('message');
    }
}
