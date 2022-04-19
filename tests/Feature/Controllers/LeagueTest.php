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

    public function testLeaguesEndpoint(): void
    {
        League::factory()
            ->create()
        ;
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
