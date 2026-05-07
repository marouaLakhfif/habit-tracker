<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create 50 users
        User::factory(50)->create()->each(function ($user) {
            // Each user creates 5-15 habits
            $habits = Habit::factory(rand(5, 15))->create(['user_id' => $user->id]);
            
            foreach ($habits as $habit) {
                // Track each habit for 30-90 days
                $days = rand(30, 90);
                $usedDates = []; // Track used dates to avoid duplicates
                
                for ($i = 0; $i < $days; $i++) {
                    $date = Carbon::today()->subDays(rand(0, 90));
                    $dateKey = $date->format('Y-m-d');
                    
                    // Skip if we already created a log for this date
                    if (in_array($dateKey, $usedDates)) {
                        continue;
                    }
                    $usedDates[] = $dateKey;
                    
                    // 70% chance of completion, higher for recent days
                    $completed = rand(1, 100) <= (70 - ($i / 5));
                    
                    // Use updateOrCreate to prevent duplicates
                    HabitLog::updateOrCreate(
                        [
                            'habit_id' => $habit->id,
                            'log_date' => $date,
                        ],
                        [
                            'completed' => $completed,
                        ]
                    );
                }
            }
        });
        
        // Create a test user with known credentials
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );
        
        $this->command->info('✅ Seeded ' . User::count() . ' users');
        $this->command->info('✅ Seeded ' . Habit::count() . ' habits');
        $this->command->info('✅ Seeded ' . HabitLog::count() . ' habit logs');
    }
}