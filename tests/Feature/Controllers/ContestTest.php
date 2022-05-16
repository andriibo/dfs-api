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
                'leagueId',
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
                    'position',
                    'photo',
                    'teamId',
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
                    'leagueId',
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
                'current_page',
                'from',
                'last_page',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    }
}
