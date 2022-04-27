<?php

namespace Tests\Unit;

use App\Enums\SportIdEnum;
use App\Factories\GameScheduleFactory;
use App\Models\Cricket\CricketGameSchedule;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class GameScheduleFactoryTest extends TestCase
{
    public function testGetClassNameCricketGameSchedule()
    {
        $className = GameScheduleFactory::getClassName(SportIdEnum::cricket->value);
        $this->assertEquals(CricketGameSchedule::class, $className);
    }
}
