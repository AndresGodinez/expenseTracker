<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryIncomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\IncomeController;
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

Route::get('category-incomes', [CategoryIncomeController::class, 'index'])
    ->middleware('auth')
    ->name('category-incomes.index');

Route::get('category-incomes/create', [CategoryIncomeController::class, 'create'])
    ->middleware('auth')
    ->name('category-incomes.create');

Route::post('category-incomes', [CategoryIncomeController::class, 'store'])
    ->middleware('auth')
    ->name('category-incomes.store');

Route::get('category-incomes/{category_income}/edit', [CategoryIncomeController::class, 'edit'])
    ->middleware('auth')
    ->name('category-incomes.edit');

Route::put('category-incomes/{category_income}', [CategoryIncomeController::class, 'update'])
    ->middleware('auth')
    ->name('category-incomes.update');

Route::delete('category-incomes/{category_income}', [CategoryIncomeController::class, 'destroy'])
    ->middleware('auth')
    ->name('category-incomes.destroy');

Route::get('accounts', [AccountController::class, 'index'])
    ->middleware('auth')
    ->name('accounts.index');

Route::get('accounts/create', [AccountController::class, 'create'])
    ->middleware('auth')
    ->name('accounts.create');

Route::post('accounts', [AccountController::class, 'store'])
    ->middleware('auth')
    ->name('accounts.store');

Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])
    ->middleware('auth')
    ->name('accounts.edit');

Route::put('accounts/{account}', [AccountController::class, 'update'])
    ->middleware('auth')
    ->name('accounts.update');

Route::delete('accounts/{account}', [AccountController::class, 'destroy'])
    ->middleware('auth')
    ->name('accounts.destroy');

Route::get('incomes', [IncomeController::class, 'index'])
    ->middleware('auth')
    ->name('incomes.index');

Route::get('incomes/create', [IncomeController::class, 'create'])
    ->middleware('auth')
    ->name('incomes.create');

Route::post('incomes', [IncomeController::class, 'store'])
    ->middleware('auth')
    ->name('incomes.store');

Route::get('incomes/{income}/edit', [IncomeController::class, 'edit'])
    ->middleware('auth')
    ->name('incomes.edit');

Route::put('incomes/{income}', [IncomeController::class, 'update'])
    ->middleware('auth')
    ->name('incomes.update');

Route::delete('incomes/{income}', [IncomeController::class, 'destroy'])
    ->middleware('auth')
    ->name('incomes.destroy');

require __DIR__.'/settings.php';
