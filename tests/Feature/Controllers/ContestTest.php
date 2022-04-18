<?php

namespace Tests\Feature\Controllers;

use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestTest extends TestCase
{
    use DatabaseTransactions;

    public function testContestTypesEndpoint()
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

    public function testContestsLobbyGetEndpoint()
    {
        $league = League::factory()
            ->create()
        ;

        $user = User::factory()
            ->create()
        ;

        $contest = Contest::factory()
            ->for($league)
            ->create()
        ;

        ContestUser::factory()
            ->for($user)
            ->for($contest)
            ->create()
        ;

        $response = $this->getJson('/api/v1/contests/lobby');
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
