<?php

namespace Tests\Unit;

use App\Calculators\PrizePlaceCalculator;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use Database\Seeders\ContestSeeder;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PrizePlaceCalculatorTest extends TestCase
{
    public function testPrizePlace(): void
    {
        $this->seed(ContestSeeder::class);
        $contest = Contest::latest('id')->first();

        /* @var $prizePlaceCalculator PrizePlaceCalculator */
        $prizePlaceCalculator = resolve(PrizePlaceCalculator::class);
        $prizes = $prizePlaceCalculator->handle($contest, $contest->contestUsers);

        $this->assertIsArray($prizes);
        $this->assertNotEmpty($prizes);
        $prize = $prizes[0];
        $this->assertInstanceOf(PrizePlace::class, $prize);
    }
}
