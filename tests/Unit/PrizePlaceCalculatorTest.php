<?php

namespace Tests\Unit;

use App\Calculators\PrizePlaceCalculator;
use App\Models\Contests\Contest;
use App\Models\League;
use App\Models\PrizePlace;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PrizePlaceCalculatorTest extends TestCase
{
    use DatabaseTransactions;

    public function testPrizePlace(): void
    {
        $league = League::factory()
            ->create()
        ;

        $contest = Contest::factory()
            ->for($league)
            ->create()
        ;

        /* @var $prizePlaceCalculator PrizePlaceCalculator */
        $prizePlaceCalculator = resolve(PrizePlaceCalculator::class);
        $prizes = $prizePlaceCalculator->handle($contest);

        $this->assertIsArray($prizes);
        $this->assertNotEmpty($prizes);
        $prize = $prizes[0];
        $this->assertInstanceOf(PrizePlace::class, $prize);
    }
}
