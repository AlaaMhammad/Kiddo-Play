<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'category' => $this->faker->randomElement(['numbers', 'letters', 'animals', 'arithmetic']),
            'title' => $this->faker->sentence(3),
            'summary' => $this->faker->optional()->sentence(),
            'content' => $this->faker->paragraph(3),
            'media_url' => $this->faker->imageUrl(400, 300, 'education'),
            'order' => $this->faker->numberBetween(1, 50),
            'is_published' => $this->faker->boolean(95),
        ];
    }
}
