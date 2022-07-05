<?php

namespace Tests\Feature\Controllers;

use App\Events\ContestUnitsUpdatedEvent;
use App\Events\ContestUpdatedEvent;
use App\Events\GameLogsUpdatedEvent;
use App\Listeners\ContestUnitsUpdatedListener;
use App\Listeners\ContestUpdatedListener;
use App\Listeners\GameLogsUpdatedListener;
use App\Models\Contests\Contest;
use Database\Seeders\ContestSeeder;
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
}
