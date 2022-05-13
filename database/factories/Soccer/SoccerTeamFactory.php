<?php

namespace Database\Factories\Soccer;

use App\Enums\FeedTypeEnum;
use App\Models\Soccer\SoccerTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class SoccerTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoccerTeam::class;

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
            'name' => $this->faker->title,
            'alias' => $this->faker->text(5),
        ];
    }
}
