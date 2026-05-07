<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabitFactory extends Factory
{
    public function definition()
    {
        $habits = [
            'Walk 30 minutes', 'Read 20 pages', 'Drink 8 glasses of water',
            'Meditate', 'Exercise', 'Study coding', 'Practice guitar',
            'Write journal', 'Eat vegetables', 'Sleep 8 hours',
            'No sugar', 'Call family', 'Learn Spanish', 'Stretch'
        ];
        
        $icons = ['🚶', '📚', '💧', '🧘', '💪', '💻', '🎸', '📝', '🥗', '😴', '🍬', '📞', '🇪🇸', '🤸'];
        
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement($habits),
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->randomElement($icons),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}