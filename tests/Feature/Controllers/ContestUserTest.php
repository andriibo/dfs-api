<?php

namespace Tests\Feature\Controllers;

use App\Models\Contests\ContestUser;
use Database\Seeders\ContestSeeder;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestUserTest extends TestCase
{
    public function testContestUserOpponentLineupEndpoint(): void
    {
        $this->seed(ContestSeeder::class);
        $contestUsers = ContestUser::query()->orderByDesc('id')->limit(2)->get();
        $entryId = $contestUsers->first()->id;
        $opponentId = $contestUsers->last()->id;
        $endpoint = "/api/v1/contest-users/{$entryId}/opponent/{$opponentId}/units";
        $user = $this->getVerifiedUser();
        $token = $this->getTokenForUser($user);
        $response = $this->getJson($endpoint, [
            'Authorization' => 'Bearer ' . $token,
        ]);
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
                        'position',
                        'photo',
                        'teamId',
                    ],
                ],
            ],
        ]);
    }
}
