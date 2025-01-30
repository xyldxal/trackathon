<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BoardListController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

// Welcome Page (for non-authenticated users)
Route::get('/', function () {
    return view('auth.login');
});

// Auth Routes (automatically added by Breeze)
require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Boards
    Route::resource('boards', BoardController::class)->only([
        'index', 'create', 'store', 'show', 'update', 'destroy'
    ]);

    // Lists
    Route::post('boards/{board}/lists', [BoardListController::class, 'store'])->name('lists.store');
    Route::patch('boards/{board}/lists/reorder', [BoardListController::class, 'updatePosition'])->name('lists.reorder');

    // Cards
    Route::resource('cards', CardController::class)->except(['index', 'create']);
    Route::patch('/cards/{card}/move', [CardController::class, 'move'])->name('cards.move');

    // Files
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // Profile (added by Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
