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
                'minPlayersError' => 'At least %s bowlers must be selected',
                'maxPlayersError' => 'Maximum %s bowlers can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BOWLER],
            ]),
            PositionConfig::CRICKET_BATSMAN => new PositionConfig([
                'id' => 'ba',
                'name' => 'Batsman',
                'shortName' => 'BT',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least %s batsmans must be selected',
                'maxPlayersError' => 'Maximum %s batsmans can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BATSMAN],
            ]),
            PositionConfig::CRICKET_BATTING_ALLROUNDER => new PositionConfig([
                'id' => 'bta',
                'name' => 'Batting Allrounder',
                'shortName' => 'BTA',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least %s Batting Allrounders must be selected',
                'maxPlayersError' => 'Maximum %s Batting Allrounders can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BATTING_ALLROUNDER],
            ]),
            PositionConfig::CRICKET_BOWLING_ALLROUNDER => new PositionConfig([
                'id' => 'bwa',
                'name' => 'Bowling Allrounder',
                'shortName' => 'BA',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least %s Bowling Allrounders must be selected',
                'maxPlayersError' => 'Maximum %s Bowling Allrounders can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_BOWLING_ALLROUNDER],
            ]),
            PositionConfig::CRICKET_WICKETKEEPER_BATSMAN => new PositionConfig([
                'id' => 'wi',
                'name' => 'Wicketkeeper Batsman',
                'shortName' => 'WB',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least %s Wicketkeeper Batsmans must be selected',
                'maxPlayersError' => 'Maximum %s Wicketkeeper Batsmans can be selected',
                'allowedPositions' => [PositionConfig::CRICKET_WICKETKEEPER_BATSMAN],
            ]),
        ];
    }
}
