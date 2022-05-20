<?php

namespace Database\Seeders;

use App\Models\ActionPoint;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestActionPoint;
use App\Models\Contests\ContestUnit;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\Soccer\SoccerPlayer;
use App\Models\Soccer\SoccerTeam;
use App\Models\Soccer\SoccerUnit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $league = League::factory()->soccer()->create();

        $contest = Contest::factory()
            ->for(League::factory()->create())
            ->create()
        ;

        $players = SoccerPlayer::factory()->count(11)->create();

        ContestActionPoint::factory()
            ->for($contest)
            ->for(ActionPoint::factory()->create())
            ->create()
        ;

        foreach ($players as $player) {
            $soccerUnit = SoccerUnit::factory()
                ->for($player, 'player')
                ->create()
            ;

            ContestUnit::factory()
                ->soccer()
                ->for(SoccerTeam::factory()->for($league)->create(), 'soccerTeam')
                ->for($soccerUnit)
                ->for($contest)
                ->create()
            ;
        }

        ContestUser::factory()
            ->for(User::factory()->verified()->create())
            ->for($contest)
            ->create()
        ;

        ContestUser::factory()
            ->for(User::factory()->verified()->create())
            ->for($contest)
            ->create()
        ;
    }
}
