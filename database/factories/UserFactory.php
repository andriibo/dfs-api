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
            'email' => $this->faker->unique()->email(),
            'password' => bcrypt('password'),
            'access_token' => Str::random(100),
            'auth_key' => Str::random(100),
            'username' => $this->faker->unique()->word(),
            'fullname' => $this->faker->name(),
            'status' => $this->faker->randomElement(StatusEnum::values()),
            'balance' => $this->faker->randomFloat(2, 0, 10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => 'test@fantasysports.com',
                'email_verified_at' => $this->faker->dateTime(),
            ];
        });
    }
}
