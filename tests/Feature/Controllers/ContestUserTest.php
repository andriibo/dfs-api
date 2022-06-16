<?php

namespace Tests\Feature\Controllers;

use App\Events\ContestUpdatedEvent;
use App\Listeners\ContestUpdatedListener;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use Database\Seeders\ContestSeeder;
use Database\Seeders\SoccerLineupSeeder;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestUserTest extends TestCase
{
    public function testContestUsersShowEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contestUser = ContestUser::latest('id')->first();
        $endpoint = "/api/v1/contest-users/{$contestUser->id}";
        $token = $this->getTokenForUser($contestUser->user);
        $response = $this->getJson($endpoint, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $this->assertResponse($response);
    }

    public function testContestUsersOpponentLineupEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contestUsers = ContestUser::query()->orderByDesc('id')->limit(2)->get();
        $entryContestUser = $contestUsers->first();
        $opponentContestUser = $contestUsers->last();
        $endpoint = "/api/v1/contest-users/{$entryContestUser->id}/opponent/{$opponentContestUser->id}";
        $token = $this->getTokenForUser($entryContestUser->user);
        $response = $this->getJson($endpoint, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $this->assertResponse($response);
    }

    public function testContestUsersCreateEndpoint(): void
    {
        $this->seed(SoccerLineupSeeder::class);
        $contest = Contest::latest('id')->first();
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $data = [
            'contestId' => $contest->id,
            'units' => [],
        ];
        foreach ($contest->contestUnits as $contestUnit) {
            $data['units'][] = ['id' => $contestUnit->id, 'position' => $contestUnit->soccerUnit->position];
        }

        Event::fake();
        Event::assertListening(ContestUpdatedEvent::class, ContestUpdatedListener::class);

        $response = $this->postJson('/api/v1/contest-users', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertCreated();
    }

    public function testContestUsersUpdateEndpoint(): void
    {
        $this->seed(SoccerLineupSeeder::class);
        $contestUser = ContestUser::latest('id')->first();
        $token = $this->getTokenForUser($contestUser->user);
        $data = [
            'units' => [],
        ];
        foreach ($contestUser->contest->contestUnits as $contestUnit) {
            $data['units'][] = ['id' => $contestUnit->id, 'position' => $contestUnit->soccerUnit->position];
        }
        $endpoint = "/api/v1/contest-users/{$contestUser->id}";
        $response = $this->putJson($endpoint, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $this->assertResponse($response);
    }

    private function assertResponse(TestResponse $response): void
    {
        $response->assertJsonStructure([
            'data' => [
                'userId',
                'username',
                'budget',
                'score',
                'prize',
                'units' => [
                    '*' => [
                        'id',
                        'playerId',
                        'totalFantasyPointsPerGame',
                        'salary',
                        'score',
                        'fullname',
                        'photo',
                        'teamId',
                        'position' => [
                            'name',
                            'alias',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
