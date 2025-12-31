<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('categories', [CategoryController::class, 'index'])
    ->middleware('auth')
    ->name('categories.index');

Route::get('categories/create', [CategoryController::class, 'create'])
    ->middleware('auth')
    ->name('categories.create');

Route::post('categories', [CategoryController::class, 'store'])
    ->middleware('auth')
    ->name('categories.store');

Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])
    ->middleware('auth')
    ->name('categories.edit');

Route::put('categories/{category}', [CategoryController::class, 'update'])
    ->middleware('auth')
    ->name('categories.update');

Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
    ->middleware('auth')
    ->name('categories.destroy');

require __DIR__.'/settings.php';
