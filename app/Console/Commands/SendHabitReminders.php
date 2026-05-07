<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\HabitReminderNotification;
use Illuminate\Console\Command;

class SendHabitReminders extends Command
{
    protected $signature = 'habits:send-reminders';
    protected $description = 'Send daily habit reminders to users';

    public function handle()
    {
        $users = User::all();
        $sent = 0;

        foreach ($users as $user) {
            $habits = $user->habits()->with('logs')->get();
            
            if ($habits->count() > 0) {
                $user->notify(new HabitReminderNotification($habits));
                $sent++;
            }
        }

        $this->info("Sent reminders to {$sent} users");
    }
}