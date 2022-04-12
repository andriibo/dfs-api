<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ContestTest extends TestCase
{
    public function testContestTypesGetEndpoint()
    {
        $response = $this->getJson('/api/v1/contests/types');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'label',
                ],
            ],
        ]);
    }
}
