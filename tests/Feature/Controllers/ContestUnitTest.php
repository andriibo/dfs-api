<?php

namespace Tests\Feature\Controllers;

use App\Models\Contests\ContestUnit;
use Database\Seeders\SoccerLineupSeeder;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestUnitTest extends TestCase
{
    public function testContestUnitsShowEndpoint(): void
    {
        $this->seed(SoccerLineupSeeder::class);
        $contestUnit = ContestUnit::latest('id')->first();
        $endpoint = "/api/v1/contest-units/{$contestUnit->id}";
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson($endpoint, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'fullname',
                'photo',
                'salary',
                'totalFantasyPoints',
                'totalFantasyPointsPerGame',
                'sportId',
                'position' => [
                    'name',
                    'alias',
                ],
                'team' => [
                    'id',
                    'name',
                    'alias',
                ],
                'nextGameSchedule' => [
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
                'lastGameStats' => [
                    '*' => [
                        'alias',
                        'title',
                        'value',
                    ],
                ],
                'lastFiveGamesStats' => [
                    '*' => [
                        'alias',
                        'title',
                        'value',
                    ],
                ],
                'totalStats' => [
                    '*' => [
                        'alias',
                        'title',
                        'value',
                    ],
                ],
            ],
        ]);
    }
}
