<?php

namespace Database\Factories;

use App\Models\Avatar;
use App\Models\Kid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KidFactory extends Factory
{
    protected $model = Kid::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'display_name' => $this->faker->firstName(),
            'dob' => $this->faker->dateTimeBetween('-12 years', '-4 years')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'avatar_id' => Avatar::factory(),
            'points' => $this->faker->numberBetween(0, 1000),
            'preferences' => [
                'favorite_color' => $this->faker->safeColorName(),
                'favorite_game' => $this->faker->word(),
            ],
        ];
    }
}
