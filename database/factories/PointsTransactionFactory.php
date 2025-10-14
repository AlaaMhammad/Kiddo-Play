<?php

namespace Database\Factories;

use App\Models\PointsTransaction;
use App\Models\Kid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PointsTransaction>
 */

class PointsTransactionFactory extends Factory
{
    protected $model = PointsTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kid_id' => Kid::factory(),
            'type' => $this->faker->randomElement(['earn', 'spend', 'adjust']),
            'amount' => $this->faker->numberBetween(5, 200),
            'source' => $this->faker->optional()->word(),
            'reference_id' => $this->faker->optional()->randomNumber(),
            'meta' => $this->faker->boolean(70)
                ? json_encode(['reason' => $this->faker->sentence()])
                : null,
        ];
    }
}
