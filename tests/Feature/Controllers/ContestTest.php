<?php

namespace Tests\Feature\Controllers;

use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\CreatesUser;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestTest extends TestCase
{
    use DatabaseTransactions;
    use CreatesUser;

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
        $this->createContests();
        $response = $this->getJson('/api/v1/contests/lobby');
        $this->assertResponse($response);
    }

    public function testContestsUpcomingEndpoint(): void
    {
        $this->createContests();
        $user = User::where('email', 'test@fantasysports.com')->first();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/upcoming', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsLiveEndpoint(): void
    {
        $this->createContests();
        $user = User::where('email', 'test@fantasysports.com')->first();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/live', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    private function createContests(): void
    {
        $league = League::factory()
            ->create()
        ;

        $user = User::factory()
            ->create()
        ;

        $contests = Contest::factory()
            ->count(10)
            ->for($league)
            ->create()
        ;

        foreach ($contests as $contest) {
            ContestUser::factory()
                ->for($user)
                ->for($contest)
                ->create()
            ;
        }
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
                    'numEntries',
                    'numUsers',
                    'entries' => [
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
        ]);
    }
}
