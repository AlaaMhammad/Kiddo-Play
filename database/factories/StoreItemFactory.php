<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreItem>
 */
class StoreItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'cost_points' => $this->faker->numberBetween(10, 500),
            'type' => $this->faker->randomElement(['avatar', 'booster', 'item']),
            'metadata' => [
                'rarity' => $this->faker->randomElement(['common', 'rare', 'epic']),
            ],
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
