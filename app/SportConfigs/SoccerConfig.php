<?php

namespace App\SportConfigs;

class SoccerConfig extends AbstractSportConfig
{
    public function __construct()
    {
        $this->positions = [
            PositionConfig::SOCCER_GOALKEEPER => new PositionConfig([
                'id' => 'gk',
                'name' => 'Goalkeeper',
                'shortName' => 'GK',
                'minPlayers' => 1,
                'maxPlayers' => 1,
                'minPlayersError' => 'One goalkeeper must be selected',
                'maxPlayersError' => 'One goalkeeper must be selected',
                'allowedPositions' => [PositionConfig::SOCCER_GOALKEEPER],
            ]),
            PositionConfig::SOCCER_FORWARD => new PositionConfig([
                'id' => 'fw',
                'name' => 'Forward',
                'shortName' => 'FW',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} forwards must be selected',
                'maxPlayersError' => 'Maximum {NUM} forwards can be selected',
                'allowedPositions' => [PositionConfig::SOCCER_FORWARD],
            ]),
            PositionConfig::SOCCER_MIDFIELD => new PositionConfig([
                'id' => 'md',
                'name' => 'Midfield',
                'shortName' => 'MD',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} midfields must be selected',
                'maxPlayersError' => 'Maximum {NUM} midfields can be selected',
                'allowedPositions' => [PositionConfig::SOCCER_MIDFIELD],
            ]),
            PositionConfig::SOCCER_DEFENDER => new PositionConfig([
                'id' => 'df',
                'name' => 'Defender',
                'shortName' => 'DF',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least {NUM} defenders must be selected',
                'maxPlayersError' => 'Maximum {NUM} defenders can be selected',
                'allowedPositions' => [PositionConfig::SOCCER_DEFENDER],
            ]),
        ];
    }
}
