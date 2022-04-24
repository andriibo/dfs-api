<?php

namespace Database\Factories;

use App\Enums\SportIdEnum;
use App\Models\ActionPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class ActionPointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActionPoint::class;

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
            'name' => $this->faker->name,
            'sport_id' => $this->faker->randomElement(SportIdEnum::values()),
            'values' => '{}',
            'title' => $this->faker->title,
            'alias' => $this->faker->unique()->text(5),
            'game_log_template' => $this->faker->text(200),
        ];
    }
}