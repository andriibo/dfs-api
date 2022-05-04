<?php

namespace Tests\Feature\Controllers;

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
                ],
            ],
        ]);
    }
}
