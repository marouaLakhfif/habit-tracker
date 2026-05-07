<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Habit Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f0f2f5;
        }
        
        /* Desktop Sidebar - Always visible on large screens */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
            border-radius: 10px;
            margin: 5px 10px;
        }
        
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }
        
        .sidebar a i {
            margin-right: 10px;
            width: 25px;
        }
        
        /* Mobile Sidebar - Hidden by default on phones */
        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                width: 280px;
                height: 100%;
                z-index: 1050;
                transition: left 0.3s ease;
                overflow-y: auto;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
                display: none;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
            
            .mobile-menu-btn {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1060;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 10px;
                padding: 10px 15px;
                font-size: 20px;
                cursor: pointer;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .main-content {
                margin-top: 60px;
                padding: 15px !important;
            }
            
            /* Better touch targets on mobile */
            .btn, button {
                min-height: 44px;
                min-width: 44px;
            }
            
            /* Stack cards on mobile */
            .col-md-3, .col-md-4, .col-md-6 {
                margin-bottom: 15px;
            }
        }
        
        /* Desktop - hide mobile elements */
        @media (min-width: 768px) {
            .mobile-menu-btn {
                display: none !important;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-complete {
            font-size: 2rem;
            padding: 10px 20px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-complete:hover {
            transform: scale(1.1);
        }
        
        .streak-fire {
            animation: pulse 1s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .habit-card {
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .habit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .progress-bar-vertical {
            height: 100px;
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .progress-bar-animated {
            animation: progressBar 1s ease-in-out;
        }
        
        @keyframes progressBar {
            0% { width: 0; }
        }
        /* Dark Mode Variables */
        :root {
            --bg-color: #f0f2f5;
            --card-bg: #ffffff;
            --text-color: #212529;
            --sidebar-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        [data-theme="dark"] {
            --bg-color: #1a1a2e;
            --card-bg: #16213e;
            --text-color: #e0e0e0;
            --sidebar-gradient: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
        }

        [data-theme="dark"] body {
            background: var(--bg-color);
            color: var(--text-color);
        }

        [data-theme="dark"] .card {
            background: var(--card-bg);
            color: var(--text-color);
        }

        [data-theme="dark"] .text-muted {
            color: #a0a0a0 !important;
        }

        [data-theme="dark"] .sidebar {
            background: var(--sidebar-gradient);
        }

        [data-theme="dark"] .table {
            color: var(--text-color);
        }

        [data-theme="dark"] .alert-success {
            background-color: #0f3460;
            color: #e0e0e0;
            border-color: #1a1a2e;
        }

        [data-theme="dark"] .progress {
            background-color: #2d2d44;
        }

        [data-theme="dark"] .list-group-item {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: #2d2d44; 
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar Overlay (closes sidebar when clicking outside) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar" id="sidebar">
                <div class="p-3">
                    <h3 class="text-white mb-4">
                        <i class="fas fa-calendar-check"></i> HabitFlow
                    </h3>
                    <hr class="bg-white">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('habits.index') }}">
                        <i class="fas fa-list"></i> My Habits
                    </a>
                    <a href="{{ route('habits.create') }}">
                        <i class="fas fa-plus-circle"></i> New Habit
                    </a>
                    <a href="{{ route('statistics') }}">
                        <i class="fas fa-chart-line"></i> Statistics
                    </a>
                    <hr class="bg-white">
                    <div class="mt-auto">
                        <button id="darkModeToggle" class="btn btn-light w-100" style="border-radius: 10px;">
                            <i class="fas fa-moon"></i> Dark Mode
                        </button>
                    </div>
                    <hr class="bg-white">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 p-4 main-content" id="mainContent">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Mobile menu toggle functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        // Close sidebar on window resize (if switching from mobile to desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
    <script>
    const darkModeToggle = document.getElementById('darkModeToggle');
    const currentTheme = localStorage.getItem('theme');
    
    if (currentTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        if (darkModeToggle) {
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
        }
    }
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            const theme = document.documentElement.getAttribute('data-theme');
            if (theme === 'dark') {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                darkModeToggle.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
            }
        });
    }
    </script>
    @stack('scripts')
</body>
</html>