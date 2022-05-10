<?php

namespace Database\Factories\Soccer;

use App\Enums\Soccer\Units\UnitType;
use App\Models\Soccer\SoccerUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class SoccerUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoccerUnit::class;

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
            'unit_type' => UnitType::player->name,
            'position' => $this->faker->numberBetween(1, 4),
            'salary' => $this->faker->randomFloat(2, 0, 10),
            'auto_salary' => $this->faker->randomFloat(2, 0, 10),
            'fantasy_points' => $this->faker->randomFloat(2, 0, 10),
            'fantasy_points_per_game' => $this->faker->randomFloat(2, 0, 10),
            'point_spread' => $this->faker->randomFloat(2, 0, 10),
        ];
    }

    public function position(int $position)
    {
        return $this->state(function (array $attributes) use ($position) {
            return [
                'position' => $position,
            ];
        });
    }
}
