<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'icon', 'color'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }

    public function getTodayLogAttribute()
    {
        return $this->logs()->where('log_date', today())->first();
    }

    public function getIsCompletedTodayAttribute()
    {
        $log = $this->getTodayLogAttribute();
        return $log ? $log->completed : false;
    }

    public function getCurrentStreakAttribute()
    {
        $streak = 0;
        $date = today();
        
        while (true) {
            $log = $this->logs()->where('log_date', $date)->where('completed', true)->first();
            if (!$log) break;
            $streak++;
            $date = $date->subDay();
        }
        
        return $streak;
    }
}