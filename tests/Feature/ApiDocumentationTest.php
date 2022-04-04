<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ApiDocumentationTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testApiDocumentation()
    {
        $response = $this->get('/api/documentation');

        $response->assertStatus(200);
    }
}
