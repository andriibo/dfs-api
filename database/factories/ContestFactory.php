<?php

namespace Database\Factories;

use App\Enums\Contests\ContestTypeEnum;
use App\Enums\Contests\EntryFeeTypeEnum;
use App\Enums\Contests\GameTypeEnum;
use App\Enums\Contests\PayoutTypeEnum;
use App\Enums\Contests\StatusEnum;
use App\Enums\Contests\TypeEnum;
use App\Models\Contest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class ContestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contest::class;

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
            'owner_id' => $this->faker->randomDigit(),
            'status' => StatusEnum::ready,
            'type' => $this->faker->randomElement(TypeEnum::names()),
            'contest_type' => $this->faker->randomElement(ContestTypeEnum::values()),
            'game_type' => $this->faker->randomElement(GameTypeEnum::values()),
            'title' => $this->faker->title,
            'entry_fee_type' => $this->faker->randomElement(EntryFeeTypeEnum::values()),
            'prize_places' => $this->faker->text,
            'payout_type' => $this->faker->randomElement(PayoutTypeEnum::values()),
            'form_start_date' => $this->faker->date,
            'form_end_date' => $this->faker->date,
        ];
    }
}
