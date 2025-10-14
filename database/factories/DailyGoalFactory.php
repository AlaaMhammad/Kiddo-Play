<?php

namespace Database\Factories;

use App\Models\DailyGoal;
use App\Models\Game;
use App\Models\Kid;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyGoalFactory extends Factory
{
    protected $model = DailyGoal::class;

    public function definition(): array
    {
        return [
            'kid_id' => Kid::factory(),
            'game_id' => Game::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'target_points' => $this->faker->numberBetween(10, 100),
            'is_completed' => $this->faker->boolean(30),
            'goal_date' => $this->faker->date(),
        ];
    }
}
