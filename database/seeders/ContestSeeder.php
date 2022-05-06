<?php

namespace Database\Seeders;

use App\Models\ActionPoint;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestActionPoint;
use App\Models\Contests\ContestUnit;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\Soccer\SoccerPlayer;
use App\Models\Soccer\SoccerUnit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $contests = Contest::factory()
            ->count(10)
            ->for(League::factory()->create())
            ->create()
        ;

        $players = SoccerPlayer::factory()->count(10)->create();

        foreach ($contests as $key => $contest) {
            ContestActionPoint::factory()
                ->for($contest)
                ->for(ActionPoint::factory()->create())
                ->create()
            ;

            $soccerUnit = SoccerUnit::factory()
                ->for($players[$key], 'player')
                ->create()
            ;

            ContestUnit::factory()
                ->for($soccerUnit)
                ->for($contest)
                ->create()
            ;

            ContestUser::factory()
                ->for(User::factory()->create())
                ->for($contest)
                ->create()
            ;

            ContestUser::factory()
                ->for(User::factory()->create())
                ->for($contest)
                ->create()
            ;
        }
    }
}
