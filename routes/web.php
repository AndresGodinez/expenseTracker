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

Route::post('categories', [CategoryController::class, 'store'])
    ->middleware('auth')
    ->name('categories.store');

require __DIR__.'/settings.php';
