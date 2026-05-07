<?php

namespace Database\Factories;

use App\Models\Habit;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabitLogFactory extends Factory
{
    public function definition()
    {
        return [
            'habit_id' => Habit::factory(),
            'log_date' => $this->faker->dateTimeBetween('-3 months', 'today'),
            'completed' => $this->faker->boolean(70), // 70% chance of completion
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}