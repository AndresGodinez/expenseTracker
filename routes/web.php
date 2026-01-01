<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/web/categories.php';
require __DIR__.'/web/payment-methods.php';
require __DIR__.'/web/expenses.php';
require __DIR__.'/web/category-incomes.php';
require __DIR__.'/web/accounts.php';
require __DIR__.'/web/incomes.php';

require __DIR__.'/settings.php';
