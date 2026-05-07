<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $habits = auth()->user()->habits()->latest()->get();
        return view('habits.index', compact('habits'));
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        auth()->user()->habits()->create($request->all());

        return redirect()->route('habits.index')->with('success', 'Habit created! 🎉');
    }

    public function edit(Habit $habit)
    {
    //    $this->authorize('update', $habit);
        return view('habits.edit', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
    //    $this->authorize('update', $habit);
    
        $request->validate([
            'name' => 'required|string|max:255',
           'description' => 'nullable|string',
        ]);

        $habit->update($request->all());

        return redirect()->route('habits.index')->with('success', 'Habit updated!');
    }

    public function destroy(Habit $habit)
    {
       // $this->authorize('delete', $habit);
        $habit->delete();

        return redirect()->route('habits.index')->with('success', 'Habit deleted!');
    }

    public function toggle(Request $request, Habit $habit)
    {
    $log = $habit->logs()->firstOrCreate(
        ['log_date' => $request->date ?? today()],
        ['completed' => false]
    );
    
    $log->completed = !$log->completed;
    $log->save();

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'completed' => $log->completed,
            'streak' => $habit->current_streak
        ]);
    }

    return back()->with('success', $log->completed ? 'Great job! ✅' : 'Keep going! 💪');
    }
}