<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Habit Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">🏆 Habit Tracker</a>
            <div class="ms-auto">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4">Welcome to Habit Tracker</h1>
                <p class="lead">Track your daily habits and improve your life. One day at a time.</p>
                
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h3>📊</h3>
                                <h5>Track Progress</h5>
                                <p>Monitor your daily habits</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h3>🔥</h3>
                                <h5>Build Streaks</h5>
                                <p>Stay consistent every day</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h3>📈</h3>
                                <h5>View Statistics</h5>
                                <p>See your improvement</p>
                            </div>
                        </div>
                    </div>
                </div>

                @guest
                    <div class="mt-5">
                        <a href="{{ route('register') }}" class="btn btn-success btn-lg">Get Started →</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</body>
</html>