<?php

namespace Database\Factories\Contests;

use App\Enums\Contests\ContestTypeEnum;
use App\Enums\Contests\EntryFeeTypeEnum;
use App\Enums\Contests\GameTypeEnum;
use App\Enums\Contests\IsPrizeBankInPercents;
use App\Enums\Contests\PayoutTypeEnum;
use App\Enums\Contests\StatusEnum;
use App\Enums\Contests\SuspendedEnum;
use App\Enums\Contests\TypeEnum;
use App\Models\Contests\Contest;
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
            'status' => $this->faker->randomElement([
                StatusEnum::started->value,
                StatusEnum::finished->value,
                StatusEnum::closed->value,
            ]),
            'type' => $this->faker->randomElement(TypeEnum::names()),
            'contest_type' => $this->faker->randomElement(ContestTypeEnum::values()),
            'game_type' => $this->faker->randomElement(GameTypeEnum::values()),
            'title' => $this->faker->name,
            'salary_cap' => $this->faker->numberBetween(1000, 10000),
            'entry_fee_type' => $this->faker->randomElement(EntryFeeTypeEnum::values()),
            'prize_places' => [
                [
                    'places' => 1,
                    'prize' => 100,
                    'voucher' => null,
                    'badge_id' => null,
                    'num_badges' => null,
                    'winners' => null,
                    'from' => null,
                    'to' => null,
                ],
            ],
            'entry_fee' => $this->faker->randomFloat(2, 1, 10),
            'is_prize_in_percents' => $this->faker->randomElement(IsPrizeBankInPercents::values()),
            'payout_type' => $this->faker->randomElement(PayoutTypeEnum::values()),
            'form_start_date' => $this->faker->date,
            'form_end_date' => $this->faker->date,
        ];
    }

    public function ready()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => StatusEnum::ready->value,
                'suspended' => SuspendedEnum::yes->value,
                'is_prize_in_percents' => IsPrizeBankInPercents::yes->value,
                'entry_fee' => 10.5,
                'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            ];
        });
    }
}
