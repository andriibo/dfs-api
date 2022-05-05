<?php

namespace Database\Factories;

use App\Enums\IsEnabledEnum;
use App\Enums\Leagues\RecentlyEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\League;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class LeagueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = League::class;

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
            'alias' => $this->faker->unique()->text(5),
            'name' => $this->faker->title,
            'season' => $this->faker->year(),
            'sport_id' => $this->faker->randomElement([SportIdEnum::soccer->value, SportIdEnum::cricket->value]),
            'is_enabled' => $this->faker->randomElement(IsEnabledEnum::values()),
            'date_updated' => $this->faker->dateTime(),
            'order' => 0,
            'config_id' => 1,
            'recently_enabled' => $this->faker->randomElement(RecentlyEnabledEnum::values()),
        ];
    }
}
