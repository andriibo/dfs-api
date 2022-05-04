<?php

namespace Tests\Feature\Controllers;

use App\Models\StaticPage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class StaticPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testStaticPagesShowEndpoint(): void
    {
        $staticPage = StaticPage::factory()
            ->create()
        ;
        $endpoint = '/api/v1/static-pages/' . $staticPage->name;
        $response = $this->getJson($endpoint);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'title',
                'content',
                'description',
                'keywords',
                'linkText',
            ],
        ]);
    }
}
