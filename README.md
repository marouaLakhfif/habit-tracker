# Habit Tracker

A full‑featured Laravel application to track daily habits, maintain streaks, and visualize progress with interactive charts.

## Features

- User authentication (register / login / logout)
- Create, edit, delete habits
- Daily completion tracking (one‑click toggle)
- Automatic streak calculation 
- Dashboard with statistics (total habits, completed today, best streak)
- Weekly progress chart (last 7 days)
- Statistics page with:
  - 30‑day trend line chart
  - This week vs last week bar chart
  - Habit completion pie chart
  - Monthly heatmap
- Dark mode toggle 
- Mobile responsive design
- Email reminders (to log file)

## Tech Stack

- Laravel 8
- PHP 7.4
- MySQL / SQLite
- Bootstrap 5
- Chart.js
- Nginx / Apache

##  Live Demo

[Live Demo – Habit Tracker](http://121.43.192.43)  
*(Note: Server may expire; check GitHub for latest deployment)*

##  Installation

```bash
git clone https://github.com/marouaLakhfif/habit-tracker.git
cd habit-tracker
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
