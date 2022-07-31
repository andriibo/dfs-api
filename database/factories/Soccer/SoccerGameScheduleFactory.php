<?php

namespace Database\Factories\Soccer;

use App\Enums\Soccer\GameSchedules\IsSalaryAvailableEnum;
use App\Models\Soccer\SoccerGameSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class SoccerGameScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoccerGameSchedule::class;

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
            'feed_id' => $this->faker->unique()->numberBetween(100000),
            'game_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'is_salary_available' => $this->faker->randomElement(IsSalaryAvailableEnum::values()),
        ];
    }
}
