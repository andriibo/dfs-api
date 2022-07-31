<?php

namespace Tests\Unit;

use App\Calculators\PrizeBankCalculator;
use App\Models\Contests\Contest;
use Database\Seeders\SoccerLineupSeeder;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PrizeBankCalculatorTest extends TestCase
{
    public function testPrizePlace(): void
    {
        $this->seed(SoccerLineupSeeder::class);
        $contest = Contest::latest('id')->first();

        $prizeBankCalculator = new PrizeBankCalculator();
        $contestUsersCount = $contest->contestUsers()->count();
        $prizeBank = $prizeBankCalculator->handle($contest, $contestUsersCount, 10);
        $this->assertIsFloat($prizeBank);
        $this->assertEquals(9.45, $prizeBank);
    }
}
