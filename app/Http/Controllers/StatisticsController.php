<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $habits = $user->habits()->with('logs')->get();
        
        $totalHabits = $habits->count();
        $totalCompletions = 0;
        $bestStreak = 0;
        $bestHabit = null;
        
        foreach ($habits as $habit) {
            $completions = $habit->logs()->where('completed', true)->count();
            $totalCompletions += $completions;
            
            $streak = $habit->current_streak;
            if ($streak > $bestStreak) {
                $bestStreak = $streak;
                $bestHabit = $habit;
            }
        }
        
        // Last 30 days data
        $last30Days = [];
        $last30Completions = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last30Days[] = $date->format('M d');
            
            $completedCount = $habits->filter(function($habit) use ($date) {
                return $habit->logs()
                    ->where('log_date', $date)
                    ->where('completed', true)
                    ->exists();
            })->count();
            
            $last30Completions[] = $completedCount;
        }
        
        // Habit completion rates
        $habitNames = [];
        $habitCompletionRates = [];
        foreach ($habits as $habit) {
            $totalDays = $habit->created_at->diffInDays(Carbon::today()) + 1;
            $completedDays = $habit->logs()->where('completed', true)->count();
            $rate = $totalDays > 0 ? round(($completedDays / $totalDays) * 100) : 0;
            
            $habitNames[] = $habit->name;
            $habitCompletionRates[] = $rate;
        }
        
        // This week vs last week
        $thisWeek = [];
        $lastWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $thisDate = Carbon::today()->subDays(6 - $i);
            $lastDate = Carbon::today()->subDays(13 - $i);
            
            $thisComplete = $habits->filter(function($habit) use ($thisDate) {
                return $habit->logs()->where('log_date', $thisDate)->where('completed', true)->exists();
            })->count();
            
            $lastComplete = $habits->filter(function($habit) use ($lastDate) {
                return $habit->logs()->where('log_date', $lastDate)->where('completed', true)->exists();
            })->count();
            
            $thisWeek[] = $thisComplete;
            $lastWeek[] = $lastComplete;
        }
        $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        
        return view('statistics', compact(
            'totalHabits',
            'totalCompletions',
            'bestStreak',
            'bestHabit',
            'last30Days',
            'last30Completions',
            'habitNames',
            'habitCompletionRates',
            'thisWeek',
            'lastWeek',
            'weekDays'
        ));
    }
}