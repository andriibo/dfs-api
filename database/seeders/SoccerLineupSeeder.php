<?php

namespace Database\Seeders;

use App\Factories\SportConfigFactory;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUnit;
use App\Models\Contests\ContestUser;
use App\Models\League;
use App\Models\Soccer\SoccerPlayer;
use App\Models\Soccer\SoccerUnit;
use App\Models\User;
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

        $sportConfig = SportConfigFactory::getConfig($league->sport_id);
        $countPositions = count($sportConfig->positions);
        $countPlayers = $sportConfig->playersInTeam;
        $i = 0;
        do {
            foreach ($sportConfig->positions as $id => $position) {
                if ($i == $countPlayers) {
                    return;
                }
                if ($position->maxPlayers > round($i / $countPositions)) {
                    $soccerUnit = SoccerUnit::factory()
                        ->position($id)
                        ->for(SoccerPlayer::factory()->create(), 'player')
                        ->create()
                    ;

                    ContestUnit::factory()
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
