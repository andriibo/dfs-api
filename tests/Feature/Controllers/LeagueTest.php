<?php

namespace Tests\Feature\Controllers;

use App\Models\League;
use Database\Seeders\LeagueSeeder;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LeagueTest extends TestCase
{
    public function testLeaguesEndpoint(): void
    {
        $this->seed(LeagueSeeder::class);
        $response = $this->getJson('/api/v1/leagues');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'alias',
                    'sportId',
                ],
            ],
        ]);
    }

    public function testLeaguesSportConfigEndpoint(): void
    {
        $league = League::factory()->create();
        $endpoint = "/api/v1/leagues/{$league->id}/sport-config";
        $response = $this->getJson($endpoint);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'playersInTeam',
                'positions' => [
                    '*' => [
                        'name',
                        'alias',
                    ],
                ],
            ],
        ]);
    }
}
