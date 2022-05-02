<?php

namespace Database\Factories\Contests;

use App\Models\Contests\ContestUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class ContestUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContestUnit::class;

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
            'team_id' => $this->faker->randomDigit(),
            'salary' => $this->faker->randomFloat(2, 0, 10),
            'fantasy_points_per_game' => $this->faker->randomFloat(2, 0, 10),
            'fantasy_points' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
