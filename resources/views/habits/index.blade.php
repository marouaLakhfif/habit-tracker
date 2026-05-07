@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list"></i> My Habits</h2>
    <a href="{{ route('habits.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus"></i> Add New Habit
    </a>
</div>

@if($habits->count() == 0)
<div class="text-center py-5">
    <i class="fas fa-clipboard-list" style="font-size: 80px; color: #ddd;"></i>
    <h3 class="mt-3">No habits yet</h3>
    <p>Create your first habit to start tracking!</p>
    <a href="{{ route('habits.create') }}" class="btn btn-primary">Create Your First Habit</a>
</div>
@else
<div class="row">
    @foreach($habits as $habit)
    <div class="col-md-6 mb-4">
        <div class="card habit-card {{ $habit->is_completed_today ? 'border-success' : '' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h4>
                            <span style="font-size: 2rem;">{{ $habit->icon ?? '✅' }}</span>
                            {{ $habit->name }}
                        </h4>
                        <p class="text-muted">{{ $habit->description }}</p>
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-fire"></i> {{ $habit->current_streak }} day streak
                            </span>
                        </div>
                    </div>
                    <div class="text-end">
                        <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                            @csrf
                            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                            <button type="submit" class="btn btn-complete {{ $habit->is_completed_today ? 'btn-success' : 'btn-outline-secondary' }}">
                                {{ $habit->is_completed_today ? '✅' : '⬜' }}
                            </button>
                        </form>
                        <div class="mt-2">
                            <a href="{{ route('habits.edit', $habit) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('habits.destroy', $habit) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this habit?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection