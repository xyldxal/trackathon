<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// boards
Route::resource('boards', BoardController::class)->middleware('auth');

// lists
Route::post('boards/{board}/lists',
    [BoardListController::class, 'store'])
    ->name('lists.store');

Route::patch('boards/{board}/lists/reorder',
    [BoardListController::class, 'updatePosition'])
    ->name('lists.reorder');

// cards
Route::resource('cards', CardController::class)
    ->except(['index', 'create']);

Route::patch('/cards/{card}/move',
    [CardController::class, 'move'])
    ->name('cards.move');

// files
Route::delete('/files/{file}',
    [FileController::class, 'destroy'])
    ->name('files.destroy');

// calendar
Route::get('/calendar',
    [CalendarController::class, 'index'])
    ->name('calendar.index');

