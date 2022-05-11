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
                'minPlayersError' => 'At least %s forwards must be selected',
                'maxPlayersError' => 'Maximum %s forwards can be selected',
                'allowedPositions' => [PositionConfig::SOCCER_FORWARD],
            ]),
            PositionConfig::SOCCER_MIDFIELD => new PositionConfig([
                'id' => 'md',
                'name' => 'Midfield',
                'shortName' => 'MD',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least %s midfields must be selected',
                'maxPlayersError' => 'Maximum %s midfields can be selected',
                'allowedPositions' => [PositionConfig::SOCCER_MIDFIELD],
            ]),
            PositionConfig::SOCCER_DEFENDER => new PositionConfig([
                'id' => 'df',
                'name' => 'Defender',
                'shortName' => 'DF',
                'minPlayers' => 2,
                'maxPlayers' => 5,
                'minPlayersError' => 'At least %s defenders must be selected',
                'maxPlayersError' => 'Maximum %s defenders can be selected',
                'allowedPositions' => [PositionConfig::SOCCER_DEFENDER],
            ]),
        ];
    }
}