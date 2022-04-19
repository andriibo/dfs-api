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

    public function testContestTypesEndpoint(): void
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

    public function testContestsLobbyGetEndpoint(): void
    {
        $this->createContests();
        $response = $this->getJson('/api/v1/contests/lobby');
        $this->assertResponse($response);
    }

    public function testContestsUpcomingGetEndpoint(): void
    {
        $this->createContests();
        $user = User::where('email', 'test@fantasysports.com')->first();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson('/api/v1/contests/upcoming', [
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
                    'contest_type',
                    'expected_payout',
                    'is_prize_in_percents',
                    'max_entries',
                    'max_users',
                    'min_users',
                    'league_id',
                    'start_date',
                    'end_date',
                    'details',
                    'entry_fee',
                    'salary_cap',
                    'prize_bank',
                    'prize_bank_type',
                    'custom_prize_bank',
                    'max_prize_bank',
                    'suspended',
                    'name',
                    'num_entries',
                    'num_users',
                    'entries' => [
                        '*' => [
                            'id',
                            'title',
                            'user_id',
                            'username',
                            'avatar',
                            'budget',
                            'date',
                            'is_winner',
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
