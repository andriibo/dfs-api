<?php

namespace Tests\Feature\Controllers;

use App\Models\ActionPoint;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestActionPoint;
use App\Models\Contests\ContestUnit;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\Soccer\SoccerPlayer;
use App\Models\Soccer\SoccerUnit;
use App\Models\User;
use App\Services\UserService;
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

    private readonly UserService $userService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->userService = resolve(UserService::class);

        parent::__construct($name, $data, $dataName);
    }

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
        $user = $this->userService->getUserByEmail('test@fantasysports.com');
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/upcoming', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsLiveEndpoint(): void
    {
        $this->createContests();
        $user = $this->userService->getUserByEmail('test@fantasysports.com');
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/live', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsHistoryEndpoint(): void
    {
        $this->createContests();
        $user = $this->userService->getUserByEmail('test@fantasysports.com');
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/history', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $this->assertResponse($response);
    }

    public function testContestsShowEndpoint(): void
    {
        $league = League::factory()
            ->create()
        ;

        $user = User::factory()
            ->create()
        ;

        $actionPoint = ActionPoint::factory()
            ->create()
        ;

        $contest = Contest::factory()
            ->for($league)
            ->create()
        ;

        ContestActionPoint::factory()
            ->for($contest)
            ->for($actionPoint)
            ->create()
        ;

        ContestUser::factory()
            ->for($user)
            ->for($contest)
            ->create()
        ;

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
                'numEntries',
                'numUsers',
                'users' => [
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

    public function testContestPlayersEndpoint(): void
    {
        $league = League::factory()
            ->create()
        ;

        $contest = Contest::factory()
            ->for($league)
            ->create()
        ;

        $soccerPlayer = SoccerPlayer::factory()
            ->create()
        ;

        $soccerUnit = SoccerUnit::factory()
            ->for($soccerPlayer, 'player')
            ->create()
        ;

        ContestUnit::factory()
            ->for($soccerUnit)
            ->for($contest)
            ->create()
        ;

        $this->createUser();
        $user = $this->userService->getUserByEmail('test@fantasysports.com');
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
