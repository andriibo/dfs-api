<?php

namespace Tests\Unit;

use App\Enums\SportIdEnum;
use App\Factories\SportConfigFactory;
use App\SportConfigs\SoccerConfig;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SportConfigFactoryTest extends TestCase
{
    public function testSportConfig(): void
    {
        $sportConfig = SportConfigFactory::getConfig(SportIdEnum::soccer->value);

        $this->assertInstanceOf(SoccerConfig::class, $sportConfig);
        $this->assertSame(11, $sportConfig->playersInTeam);
        $this->assertSame(3, $sportConfig->minTeams);
        $this->assertSame(7200, $sportConfig->gameDuration);
        $this->assertIsArray($sportConfig->positions);
    }
}
