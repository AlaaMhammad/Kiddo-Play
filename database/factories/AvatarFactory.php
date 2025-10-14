<?php

namespace Database\Factories;

use App\Models\Avatar;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvatarFactory extends Factory
{
    protected $model = Avatar::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'image_url' => 'avatars/avatar' . $this->faker->numberBetween(1, 10) . '.png', // اختر صورة عشوائية
            'cost_points' => $this->faker->numberBetween(0, 500),
            'is_active' => $this->faker->boolean(90), // 90% احتمال يكون مفعّل
        ];
    }
}
