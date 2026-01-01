<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ExpenseController;
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

Route::get('payment-methods', [PaymentMethodController::class, 'index'])
    ->middleware('auth')
    ->name('payment-methods.index');

Route::get('payment-methods/create', [PaymentMethodController::class, 'create'])
    ->middleware('auth')
    ->name('payment-methods.create');

Route::post('payment-methods', [PaymentMethodController::class, 'store'])
    ->middleware('auth')
    ->name('payment-methods.store');

Route::get('payment-methods/{payment_method}/edit', [PaymentMethodController::class, 'edit'])
    ->middleware('auth')
    ->name('payment-methods.edit');

Route::put('payment-methods/{payment_method}', [PaymentMethodController::class, 'update'])
    ->middleware('auth')
    ->name('payment-methods.update');

Route::delete('payment-methods/{payment_method}', [PaymentMethodController::class, 'destroy'])
    ->middleware('auth')
    ->name('payment-methods.destroy');

Route::get('expenses', [ExpenseController::class, 'index'])
    ->middleware('auth')
    ->name('expenses.index');

Route::get('expenses/create', [ExpenseController::class, 'create'])
    ->middleware('auth')
    ->name('expenses.create');

Route::post('expenses', [ExpenseController::class, 'store'])
    ->middleware('auth')
    ->name('expenses.store');

Route::get('expenses/{expense}/edit', [ExpenseController::class, 'edit'])
    ->middleware('auth')
    ->name('expenses.edit');

Route::put('expenses/{expense}', [ExpenseController::class, 'update'])
    ->middleware('auth')
    ->name('expenses.update');

Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])
    ->middleware('auth')
    ->name('expenses.destroy');

require __DIR__.'/settings.php';
