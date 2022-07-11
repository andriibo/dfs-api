<?php

namespace Database\Seeders;

use App\Models\ActionPoint;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestActionPoint;
use App\Models\Contests\ContestGame;
use App\Models\Contests\ContestUnit;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\Soccer\SoccerGameSchedule;
use App\Models\Soccer\SoccerPlayer;
use App\Models\Soccer\SoccerTeam;
use App\Models\Soccer\SoccerUnit;
use App\Models\Soccer\SoccerUnitStats;
use App\Models\User;
use FantasySports\SportConfig\Factories\SportConfigFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoccerLineupSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $league = League::factory()->soccer()->create();

        $contest = Contest::factory()
            ->ready()
            ->for($league)
            ->create()
        ;

        ContestUser::factory()
            ->for(User::factory()->verified()->create())
            ->for($contest)
            ->create()
        ;

        ContestActionPoint::factory()
            ->for($contest)
            ->for(ActionPoint::factory()->create())
            ->create()
        ;

        $sportConfig = SportConfigFactory::getConfig($league->sport_id);
        $countPositions = count($sportConfig->positions);
        $countPlayers = $sportConfig->playersInTeam;
        $i = 0;
        do {
            foreach ($sportConfig->positions as $name => $position) {
                if ($i == $countPlayers) {
                    return;
                }
                if ($position->maxPlayers > round($i / $countPositions)) {
                    $soccerPlayer = SoccerPlayer::factory()->create();
                    $soccerUnit = SoccerUnit::factory()
                        ->position($name)
                        ->for($soccerPlayer, 'player')
                        ->create()
                    ;

                    $soccerTeam = SoccerTeam::factory()->for($league)->create();
                    for ($j = 0; $j < 5; ++$j) {
                        $soccerGameSchedule = SoccerGameSchedule::factory()
                            ->for($league)
                            ->for($soccerTeam, 'homeTeam')
                            ->for($soccerTeam, 'awayTeam')
                            ->create()
                        ;

                        ContestGame::factory()
                            ->for($soccerGameSchedule)
                            ->for($contest)
                            ->create()
                        ;

                        SoccerUnitStats::factory()
                            ->for($soccerGameSchedule, 'gameSchedule')
                            ->for($soccerUnit, 'unit')
                            ->for($soccerTeam, 'team')
                            ->create()
                        ;
                    }

                    SoccerUnitStats::factory()
                        ->for($soccerUnit, 'unit')
                        ->create()
                    ;

                    ContestUnit::factory()
                        ->soccer()
                        ->for($soccerTeam, 'soccerTeam')
                        ->for($soccerUnit)
                        ->for($contest)
                        ->create()
                    ;

                    ++$i;
                }
            }
        } while ($i < $countPlayers);
    }
}
