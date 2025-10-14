<?php

namespace Database\Factories;

use App\Models\ParentChild;
use App\Models\User;
use App\Models\Kid;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParentChildFactory extends Factory
{
    protected $model = ParentChild::class;

    public function definition(): array
    {
        return [
            'parent_id' => User::factory(),
            'kid_id' => Kid::factory(),
        ];
    }
}
