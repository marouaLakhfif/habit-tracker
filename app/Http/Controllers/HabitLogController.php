<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HabitLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function track(Habit $habit)
    {
        
        // Get last 30 days of logs
        $logs = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $log = $habit->logs()->where('log_date', $date)->first();
            
            $logs[] = [
                'date' => $date,
                'completed' => $log ? $log->completed : false,
                'notes' => $log ? $log->notes : '',
            ];
        }
        
        return view('habits.track', compact('habit', 'logs'));
    }

    public function toggle(Request $request, Habit $habit)
    {
    // Get the date from request, or use today
    $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::today();
    
    // Find or create the log for this date
    $log = $habit->logs()->firstOrCreate(
        ['log_date' => $date->format('Y-m-d')],
        ['completed' => false]
    );
    
    // Toggle the completed status
    $log->completed = !$log->completed;
    $log->save();
    
    // Return response
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'completed' => $log->completed,
            'streak' => $habit->current_streak
        ]);
    }
    
    return back()->with('success', $log->completed ? 'Great job! ✅' : 'Keep going! 💪');
    }

    public function updateNotes(Request $request, Habit $habit)
    {
        
        $log = $habit->logs()->firstOrCreate(
            ['log_date' => $request->date],
            ['completed' => false]
        );
        
        $log->notes = $request->notes;
        $log->save();
        
        return back()->with('success', 'Notes saved!');
    }
}