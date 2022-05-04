<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class TransactionTest extends TestCase
{
    public function testTransactionsDailyBonusEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/transactions/daily-bonus', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk();
        $response->assertSee('message');
    }
}
