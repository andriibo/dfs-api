<?php

namespace Tests\Unit;

use App\Calculators\PrizePlaceCalculator;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\PrizePlace;
use App\Models\User;
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

        $user = User::factory()
            ->create()
        ;

        $contest = Contest::factory()
            ->for($league)
            ->create()
        ;

        $contestUsers = ContestUser::factory()
            ->count(1)
            ->for($user)
            ->for($contest)
            ->create()
        ;

        /* @var $prizePlaceCalculator PrizePlaceCalculator */
        $prizePlaceCalculator = resolve(PrizePlaceCalculator::class);
        $prizes = $prizePlaceCalculator->handle($contest, $contestUsers);

        $this->assertIsArray($prizes);
        $this->assertNotEmpty($prizes);
        $prize = $prizes[0];
        $this->assertInstanceOf(PrizePlace::class, $prize);
    }
}
