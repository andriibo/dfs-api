<?php

namespace Database\Factories;

use App\Enums\Users\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Models\UserTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class UserTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTransaction::class;

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
            'type' => $this->faker->randomElement(TypeEnum::values()),
            'status' => $this->faker->randomElement(StatusEnum::values()),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
        ];
    }
}
