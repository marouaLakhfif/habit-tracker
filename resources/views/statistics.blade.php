@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-chart-line"></i> Statistics Dashboard</h2>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Habits</h5>
                    <h2 class="display-4">{{ $totalHabits }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Completions</h5>
                    <h2 class="display-4">{{ $totalCompletions }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Best Streak</h5>
                    <h2 class="display-4">{{ $bestStreak }} 🔥</h2>
                    @if($bestHabit)
                    <small>{{ $bestHabit->name }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart 1: Last 30 Days Trend -->
    <div class="card mb-4">
        <div class="card-header">
            <h5><i class="fas fa-chart-line"></i> Last 30 Days Trend</h5>
        </div>
        <div class="card-body">
            <canvas id="trendChart" style="width: 100%; height: 300px;"></canvas>
        </div>
    </div>
    
    <!-- Chart 2: This Week vs Last Week -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar"></i> Weekly Comparison</h5>
                </div>
                <div class="card-body">
                    <canvas id="weeklyChart" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Habit Completion Rates</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Wait for page to fully load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Loading charts...');
        
        // Get the data from PHP
        const last30Days = {!! json_encode($last30Days) !!};
        const last30Completions = {!! json_encode($last30Completions) !!};
        const weekDays = {!! json_encode($weekDays) !!};
        const thisWeek = {!! json_encode($thisWeek) !!};
        const lastWeek = {!! json_encode($lastWeek) !!};
        const habitNames = {!! json_encode($habitNames) !!};
        const habitRates = {!! json_encode($habitCompletionRates) !!};
        
        console.log('Last 30 days:', last30Days);
        console.log('Completions:', last30Completions);
        
        // Chart 1: Line Chart
        const trendCanvas = document.getElementById('trendChart');
        if (trendCanvas) {
            new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: last30Days,
                    datasets: [{
                        label: 'Habits Completed',
                        data: last30Completions,
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#3498db',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
            console.log('Line chart created');
        } else {
            console.log('trendChart canvas not found');
        }
        
        // Chart 2: Bar Chart
        const weeklyCanvas = document.getElementById('weeklyChart');
        if (weeklyCanvas) {
            new Chart(weeklyCanvas, {
                type: 'bar',
                data: {
                    labels: weekDays,
                    datasets: [
                        {
                            label: 'This Week',
                            data: thisWeek,
                            backgroundColor: '#3498db',
                            borderRadius: 5
                        },
                        {
                            label: 'Last Week',
                            data: lastWeek,
                            backgroundColor: '#95a5a6',
                            borderRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
            console.log('Bar chart created');
        }
        
        // Chart 3: Pie Chart
        const pieCanvas = document.getElementById('pieChart');
        if (pieCanvas) {
            new Chart(pieCanvas, {
                type: 'pie',
                data: {
                    labels: habitNames,
                    datasets: [{
                        data: habitRates,
                        backgroundColor: ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e', '#e84393', '#00cec9'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'right' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
            console.log('Pie chart created');
        }
    });
</script>
@endpush