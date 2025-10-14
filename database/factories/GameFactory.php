<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement(['educational', 'fun', 'mixed']),
            'difficulty_level' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'media_url' => $this->faker->imageUrl(640, 480, 'games'),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
