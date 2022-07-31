<?php

namespace Database\Factories\Soccer;

use App\Enums\FeedTypeEnum;
use App\Enums\Soccer\Players\InjuryStatusEnum;
use App\Enums\SportIdEnum;
use App\Models\Soccer\SoccerPlayer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class SoccerPlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoccerPlayer::class;

    /**
     * The number of models that should be generated.
     *
     * @var null|int
     */
    protected $count = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'feed_type' => $this->faker->randomElement(FeedTypeEnum::names()),
            'feed_id' => $this->faker->unique()->numberBetween(100000),
            'sport_id' => $this->faker->randomElement(SportIdEnum::values()),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'injury_status' => $this->faker->randomElement(InjuryStatusEnum::names()),
            'salary' => $this->faker->randomFloat(2, 0, 10),
            'auto_salary' => $this->faker->randomFloat(2, 0, 10),
            'total_fantasy_points' => $this->faker->randomFloat(2, 0, 10),
            'total_fantasy_points_per_game' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
