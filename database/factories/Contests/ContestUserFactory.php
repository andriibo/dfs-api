<?php

namespace Database\Factories\Contests;

use App\Models\Contests\ContestUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class ContestUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContestUser::class;

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
            'title' => $this->faker->title,
            'team_score' => $this->faker->randomFloat(),
            'place' => $this->faker->randomDigit(),
            'prize' => $this->faker->randomFloat(),
            'barcode' => $this->faker->text(30),
        ];
    }
}
