<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

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
