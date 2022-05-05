<?php

namespace App\SportConfigs;

class CricketConfig extends AbstractSportConfig
{
    public function __construct()
    {
        $this->positions = [
            PositionConfig::CRICKET_BOWLER => new PositionConfig([
                'id' => 'bw',
                'name' => 'Bowler',
                'shortName' => 'BW',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} bowlers must be selected',
                'maxPlayersError' => 'Maximum {NUM} bowlers can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BOWLER],
            ]),
            PositionConfig::CRICKET_BATSMAN => new PositionConfig([
                'id' => 'ba',
                'name' => 'Batsman',
                'shortName' => 'BT',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} batsmans must be selected',
                'maxPlayersError' => 'Maximum {NUM} batsmans can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BATSMAN],
            ]),
            PositionConfig::CRICKET_BATTING_ALLROUNDER => new PositionConfig([
                'id' => 'bta',
                'name' => 'Batting Allrounder',
                'shortName' => 'BTA',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} Batting Allrounders must be selected',
                'maxPlayersError' => 'Maximum {NUM} Batting Allrounders can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BATTING_ALLROUNDER],
            ]),
            PositionConfig::CRICKET_BOWLING_ALLROUNDER => new PositionConfig([
                'id' => 'bwa',
                'name' => 'Bowling Allrounder',
                'shortName' => 'BA',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} Bowling Allrounders must be selected',
                'maxPlayersError' => 'Maximum {NUM} Bowling Allrounders can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BOWLING_ALLROUNDER],
            ]),
            PositionConfig::CRICKET_WICKETKEEPER_BATSMAN => new PositionConfig([
                'id' => 'wi',
                'name' => 'Wicketkeeper Batsman',
                'shortName' => 'WB',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} Wicketkeeper Batsmans must be selected',
                'maxPlayersError' => 'Maximum {NUM} Wicketkeeper Batsmans can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_WICKETKEEPER_BATSMAN],
            ]),
        ];
    }
}
