<?php

namespace Database\Factories;

use App\Models\DailyGoal;
use App\Models\Purchase;
use App\Models\Kid;
use App\Models\Reward;
use App\Models\StoreItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'kid_id' => Kid::factory(),
            'store_item_id' => StoreItem::factory(),
            'points_used' => $this->faker->numberBetween(10, 300),
            'details' => [
                'note' => $this->faker->sentence(),
                'method' => $this->faker->randomElement(['auto', 'manual']),
            ],
        ];
    }
}
