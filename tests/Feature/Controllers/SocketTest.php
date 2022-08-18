<?php

namespace Tests\Feature\Controllers;

use App\Events\ContestUnitsUpdatedEvent;
use App\Events\ContestUpdatedEvent;
use App\Events\GameLogsUpdatedEvent;
use App\Events\UserTransactionCreatedEvent;
use App\Listeners\ContestUnitsUpdatedListener;
use App\Listeners\ContestUpdatedListener;
use App\Listeners\GameLogsUpdatedListener;
use App\Listeners\UserTransactionCreatedListener;
use App\Models\Contests\Contest;
use App\Models\UserTransaction;
use Database\Seeders\ContestSeeder;
use Database\Seeders\UserTransactionSeeder;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SocketTest extends TestCase
{
    public function testSocketContestEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/contests/' . $contest->id;
        Event::fake();
        Event::assertListening(ContestUpdatedEvent::class, ContestUpdatedListener::class);
        $response = $this->getJson($endpoint);
        $response->assertCreated();
    }

    public function testSocketContestPlayersEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/contests/' . $contest->id . '/players';
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        Event::fake();
        Event::assertListening(ContestUnitsUpdatedEvent::class, ContestUnitsUpdatedListener::class);
        $response = $this->getJson($endpoint, [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }

    public function testSocketContestGameLogsEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/contests/' . $contest->id . '/game-logs';
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        Event::fake();
        Event::assertListening(GameLogsUpdatedEvent::class, GameLogsUpdatedListener::class);
        $response = $this->getJson($endpoint, [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }

    public function testSocketUserTransactionEndpoint(): void
    {
        $this->seed(UserTransactionSeeder::class);
        $userTransaction = UserTransaction::latest('id')->first();
        $endpoint = '/api/v1/sockets/user-transactions/' . $userTransaction->id;
        $token = $this->getTokenForUser($userTransaction->user);
        Event::fake();
        Event::assertListening(UserTransactionCreatedEvent::class, UserTransactionCreatedListener::class);
        $response = $this->getJson($endpoint, [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }
}
