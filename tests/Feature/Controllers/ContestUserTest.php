<?php

namespace Tests\Feature\Controllers;

use App\Models\Contests\ContestUser;
use Database\Seeders\ContestSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestUserTest extends TestCase
{
    public function testContestUsersLineupEndpoint(): void
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

    private function assertResponse(TestResponse $response): void
    {
        $response->assertOk();
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
