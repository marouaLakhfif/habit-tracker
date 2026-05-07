@extends('layouts.app')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary card-hover">
            <div class="card-body">
                <h5 class="card-title">Total Habits</h5>
                <h2>{{ $totalHabits }}</h2>
                <small>Active habits</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success card-hover">
            <div class="card-body">
                <h5 class="card-title">Completed Today</h5>
                <h2>{{ $completedToday }} / {{ $totalHabits }}</h2>
                <small>✅ Today's progress</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning card-hover">
            <div class="card-body">
                <h5 class="card-title">Best Streak</h5>
                <h2>{{ $bestStreak }} <span class="streak-fire">🔥</span></h2>
                <small>Longest streak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info card-hover">
            <div class="card-body">
                <h5 class="card-title">Total Completions</h5>
                <h2>{{ $totalCompletions }}</h2>
                <small>All-time achievements</small>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Progress - Modern Cards -->
<div class="card mb-4">
    <div class="card-header bg-gradient-primary text-white">
        <h5 class="mb-0"><i class="fas fa-calendar-week"></i> Weekly Progress</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($weeklyData as $day)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-3">
                        <h3 class="mb-2">{{ $day['day'] }}</h3>
                        <div class="display-4 mb-2">
                            <span class="text-success">{{ $day['completed'] }}</span>
                            <small class="text-muted">/{{ $day['total'] }}</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $day['total'] > 0 ? ($day['completed'] / $day['total']) * 100 : 0 }}%">
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                {{ $day['total'] > 0 ? round(($day['completed'] / $day['total']) * 100) : 0 }}% complete
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
    }
    .progress {
        background-color: #f0f0f0;
        border-radius: 10px;
    }
    .progress-bar {
        border-radius: 10px;
        transition: width 0.5s ease;
    }
</style>

<!-- Recent Habits -->
<div class="card">
    <div class="card-header">
        <h5>📋 Recent Habits</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach($recentHabits as $habit)
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $habit->name }}</strong>
                        <p class="mb-0 small text-muted">{{ $habit->description }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">🔥 {{ $habit->current_streak }} day streak</span>
                        <small class="d-block">{{ $habit->completion_percentage }}% overall</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection