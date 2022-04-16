<?php

namespace Database\Factories;

use App\Enums\Users\StatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Str::random(100),
            'access_token' => Str::random(100),
            'auth_key' => Str::random(100),
            'username' => $this->faker->username(),
            'fullname' => $this->faker->name(),
            'status' => $this->faker->randomElement(StatusEnum::values()),
            'balance' => $this->faker->randomFloat(2),
        ];
    }
}
