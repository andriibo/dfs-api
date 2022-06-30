<?php

namespace Tests\Feature\Controllers;

use App\Events\ContestUnitsUpdatedEvent;
use App\Events\ContestUpdatedEvent;
use App\Events\ContestUsersUpdatedEvent;
use App\Events\GameLogsUpdatedEvent;
use App\Events\GameSchedulesUpdatedEvent;
use App\Events\UserTransactionCreatedEvent;
use App\Listeners\ContestUnitsUpdatedListener;
use App\Listeners\ContestUpdatedListener;
use App\Listeners\ContestUsersUpdatedListener;
use App\Listeners\GameLogsUpdatedListener;
use App\Listeners\GameSchedulesUpdatedListener;
use App\Listeners\UserTransactionCreatedListener;
use App\Models\Contests\Contest;
use App\Models\UserTransaction;
use Database\Seeders\ContestSeeder;
use Database\Seeders\TransactionSeeder;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SocketTest extends TestCase
{
    public function testContestEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/' . $contest->id . '/contest';
        Event::fake();
        Event::assertListening(ContestUpdatedEvent::class, ContestUpdatedListener::class);
        $response = $this->getJson($endpoint);
        $response->assertCreated();
    }

    public function testContestUnitsEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/' . $contest->id . '/contest-units';
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

    public function testContestUsersEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/' . $contest->id . '/contest-users';
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        Event::fake();
        Event::assertListening(ContestUsersUpdatedEvent::class, ContestUsersUpdatedListener::class);
        $response = $this->getJson($endpoint, [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }

    public function testUserTransactionEndpoint(): void
    {
        $this->seed(TransactionSeeder::class);
        $userTransaction = UserTransaction::latest('id')->first();
        $endpoint = '/api/v1/sockets/' . $userTransaction->id . '/user-transaction';
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        Event::fake();
        Event::assertListening(UserTransactionCreatedEvent::class, UserTransactionCreatedListener::class);
        $response = $this->getJson($endpoint, [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }

    public function testGameLogsEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/' . $contest->id . '/game-logs';
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

    public function testGameSchedulesLogsEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/sockets/' . $contest->id . '/game-schedules';
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        Event::fake();
        Event::assertListening(GameSchedulesUpdatedEvent::class, GameSchedulesUpdatedListener::class);
        $response = $this->getJson($endpoint, [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }
}
