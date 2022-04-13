<?php

namespace Tests\Feature\Controllers;

use App\Models\League;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LeagueTest extends TestCase
{
    use DatabaseTransactions;

    public function testLeaguesGetEndpoint()
    {
        League::factory()
            ->create()
        ;
        $response = $this->getJson('/api/v1/leagues');
        $response->assertSuccessful();
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
