<?php

namespace Tests\Feature\Controllers;

use App\Models\Contests\Contest;
use Database\Seeders\ContestSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestTest extends TestCase
{
    public function testContestsTypesEndpoint(): void
    {
        $response = $this->getJson('/api/v1/contests/types');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'label',
                ],
            ],
        ]);
    }

    public function testContestsLobbyEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $response = $this->getJson('/api/v1/contests/lobby');
        $this->assertResponse($response);
    }

    public function testContestsUpcomingEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/upcoming', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsLiveEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/live', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsHistoryEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/history', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsShowEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $endpoint = '/api/v1/contests/' . $contest->id;
        $response = $this->getJson($endpoint);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'type',
                'contestType',
                'expectedPayout',
                'isPrizeInPercents',
                'maxEntries',
                'maxUsers',
                'minUsers',
                'startDate',
                'endDate',
                'details',
                'entryFee',
                'salaryCap',
                'prizeBank',
                'prizeBankType',
                'customPrizeBank',
                'maxPrizeBank',
                'suspended',
                'name',
                'league' => [
                    'id',
                    'name',
                    'alias',
                    'sportId',
                ],
                'contestUsers' => [
                    '*' => [
                        'id',
                        'title',
                        'userId',
                        'username',
                        'avatar',
                        'budget',
                        'date',
                        'isWinner',
                        'place',
                        'prize',
                        'score',
                    ],
                ],
                'games' => [
                    '*' => [
                        'id',
                        'startDate',
                        'awayTeamScore',
                        'homeTeamScore',
                        'awayTeam' => [
                            'id',
                            'name',
                            'alias',
                        ],
                        'homeTeam' => [
                            'id',
                            'name',
                            'alias',
                        ],
                    ],
                ],
                'prizes' => [
                    '*' => [
                        'places',
                        'prize',
                        'voucher',
                        'badgeId',
                        'numBadges',
                        'winners',
                        'from',
                        'to',
                    ],
                ],
                'scoring' => [
                    '*' => [
                        'id',
                        'name',
                        'sportId',
                        'alias',
                        'gameLogTemplate',
                        'values',
                    ],
                ],
            ],
        ]);
    }

    public function testContestsPlayersEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $endpoint = "/api/v1/contests/{$contest->id}/players";
        $response = $this->getJson($endpoint, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'playerId',
                    'totalFantasyPointsPerGame',
                    'salary',
                    'score',
                    'fullname',
                    'photo',
                    'teamId',
                    'sportId',
                    'position',
                ],
            ],
        ]);
    }

    public function testContestsGameLogsEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();
        $user = $contest->contestUsers()->first()->user;
        $token = $this->getTokenForUser($user);
        $endpoint = "/api/v1/contests/{$contest->id}/game-logs";
        $response = $this->getJson($endpoint, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'playerId',
                    'playerName',
                    'score',
                    'message',
                ],
            ],
        ]);
    }

    private function assertResponse(TestResponse $response): void
    {
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'status',
                    'type',
                    'contestType',
                    'expectedPayout',
                    'isPrizeInPercents',
                    'maxEntries',
                    'maxUsers',
                    'minUsers',
                    'startDate',
                    'endDate',
                    'details',
                    'entryFee',
                    'salaryCap',
                    'prizeBank',
                    'prizeBankType',
                    'customPrizeBank',
                    'maxPrizeBank',
                    'suspended',
                    'name',
                    'league' => [
                        'id',
                        'name',
                        'alias',
                        'sportId',
                    ],
                    'contestUsers' => [
                        '*' => [
                            'id',
                            'title',
                            'userId',
                            'username',
                            'avatar',
                            'budget',
                            'date',
                            'isWinner',
                            'place',
                            'prize',
                            'score',
                        ],
                    ],
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'currentPage',
                'from',
                'lastPage',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'path',
                'perPage',
                'to',
                'total',
            ],
        ]);
    }
}
