<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use App\Http\Controllers\StatisticsController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('habits', HabitController::class);
    Route::get('/habits/{habit}/track', [HabitLogController::class, 'track'])->name('habits.track');
    Route::post('/habits/{habit}/toggle', [HabitLogController::class, 'toggle'])->name('habits.toggle');
    Route::post('/habits/{habit}/notes', [HabitLogController::class, 'updateNotes'])->name('habits.notes');
    Route::get('/statistics', [App\Http\Controllers\StatisticsController::class, 'index'])->name('statistics');
});