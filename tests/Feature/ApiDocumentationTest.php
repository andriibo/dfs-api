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
        $response = $this->get('/api/v1/documentation');
        $response->assertSuccessful();
        $response->assertStatus(200);
    }
}
