<?php

namespace Database\Factories\Soccer;

use App\Models\Soccer\SoccerUnitStats;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class SoccerUnitStatsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoccerUnitStats::class;

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
            'stats' => [
                'one' => 1,
                'two' => 2,
                'three' => 1,
                'four' => 9,
                'five' => 2,
                'six' => 1,
                'seven' => 1,
            ],
            'raw_stats' => [
                'one' => 1,
                'two' => 2,
                'three' => 1,
                'four' => 9,
                'five' => 2,
                'six' => 1,
                'seven' => 1,
                'eight' => 4,
                'nine' => 7,
                'ten' => 1,
            ],
        ];
    }
}
