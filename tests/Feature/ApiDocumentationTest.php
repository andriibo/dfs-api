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
    public function testApiDocumentation(): void
    {
        $response = $this->get('/api/v1/documentation');
        $response->assertOk();
    }
}
