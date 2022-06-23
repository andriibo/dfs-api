<?php

namespace Tests\Feature\Controllers;

use App\Events\UserBalanceUpdatedEvent;
use App\Listeners\UserBalanceUpdatedListener;
use Database\Seeders\TransactionSeeder;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class TransactionTest extends TestCase
{
    public function testTransactionsEndpoint(): void
    {
        $this->seed(TransactionSeeder::class);
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/transactions', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'amount',
                    'status',
                    'createdAt',
                    'updatedAt',
                ],
            ],
        ]);
    }

    public function testTransactionsDailyBonusEndpoint(): void
    {
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/transactions/daily-bonus', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        Event::fake();
        Event::assertListening(UserBalanceUpdatedEvent::class, UserBalanceUpdatedListener::class);

        $response->assertOk();
        $response->assertSee('message');
    }
}
