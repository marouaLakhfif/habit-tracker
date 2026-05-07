<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HabitReminderNotification extends Notification
{
    use Queueable;


    protected $habits;

    public function __construct($habits)
    {
        $this->habits = $habits;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $incompleteCount = $this->habits->filter(function($habit) {
            return !$habit->is_completed_today;
        })->count();

        return (new MailMessage)
            ->subject('⏰ Daily Habit Reminder')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("You have {$incompleteCount} habits to complete today.")
            ->line('**Your habits for today:**')
            ->action('View Your Habits', url('/habits'))
            ->line('Keep going! Every small step counts. 🔥');
    }
}
