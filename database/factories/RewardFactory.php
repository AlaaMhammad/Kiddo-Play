<?php

namespace Database\Factories;

use App\Models\DailyGoal;
use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

class RewardFactory extends Factory
{
    protected $model = Reward::class;

    public function definition(): array
    {
        $isClaimed = $this->faker->boolean(40);

        return [
            'daily_goal_id' => DailyGoal::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->sentence(),
            'points_required' => $this->faker->numberBetween(10, 200),
            'is_claimed' => $isClaimed,
            'claimed_at' => $isClaimed ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
        ];
    }
}
