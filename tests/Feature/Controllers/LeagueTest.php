<?php

namespace Tests\Feature\Controllers;

use App\Models\Contest;
use App\Models\League;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class LeagueTest.
 *
 * @internal
 * @coversNothing
 */
class LeagueTest extends TestCase
{
    use DatabaseTransactions;

    public function testLeaguesGetEndpoint()
    {
        League::factory()
            ->count(1)
            ->has(Contest::factory()->count(3))
            ->create()
        ;
        $response = $this->getJson('/api/v1/leagues');

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
