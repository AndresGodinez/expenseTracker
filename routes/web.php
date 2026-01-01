<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return Inertia::render('Home', [
        'can_register' => Features::enabled(Features::registration()),
        'login_url' => route('login'),
        'register_url' => route('register'),
        'dashboard_url' => route('dashboard'),
        'sales_email' => 'ventas@carvaz.com',
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
require __DIR__.'/web/monthly-reports.php';

require __DIR__.'/settings.php';
