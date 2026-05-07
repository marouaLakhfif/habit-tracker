<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }


    // Add this method to check if goal is achieved
    public function getIsGoalAchievedAttribute()
    {
    if ($this->goal_type == 'days' && $this->target_days) {
        return $this->logs()->where('completed', true)->count() >= $this->target_days;
    }
    if ($this->goal_type == 'date' && $this->end_date) {
        return $this->logs()->where('completed', true)
            ->where('log_date', '<=', $this->end_date)
            ->count() >= $this->target_days ?? 1;
    }
    return false;
    }

    public function getProgressPercentageAttribute()
    {
    if ($this->goal_type == 'days' && $this->target_days) {
        $completed = $this->logs()->where('completed', true)->count();
        return min(100, round(($completed / $this->target_days) * 100));
    }
    return null;
    }
}