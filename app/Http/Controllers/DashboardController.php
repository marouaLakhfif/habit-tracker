<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    $user = auth()->user();
    $habits = $user->habits;
    
    $totalHabits = $habits->count();
    $completedToday = $habits->filter->is_completed_today->count();
    $bestStreak = $habits->max('current_streak') ?? 0;
    $totalCompletions = $habits->sum(fn($h) => $h->logs()->where('completed', true)->count());
    $recentHabits = $user->habits()->latest()->take(5)->get();
    
    // Weekly data
    $weeklyData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $completed = $habits->filter(function($habit) use ($date) {
            return $habit->logs()->where('log_date', $date)->where('completed', true)->exists();
        })->count();
        
        $weeklyData[] = [
            'day' => $date->format('D'),
            'completed' => $completed,
            'total' => $totalHabits,
        ];
    }
    
    return view('dashboard', compact('totalHabits', 'completedToday', 'bestStreak', 'totalCompletions', 'weeklyData', 'recentHabits'));
    }
}