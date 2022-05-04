<?php

namespace Tests\Unit;

use App\Helpers\ActionPointHelper;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ActionPointHelperTest extends TestCase
{
    public function testGetScore(): void
    {
        $actionPointValues = ['1' => '10', '2' => '7', '3' => '30', '4' => '4'];
        $score = ActionPointHelper::getScore(4, $actionPointValues, 2);
        $this->assertIsFloat($score);
        $this->assertEquals(28, $score);
    }
}
