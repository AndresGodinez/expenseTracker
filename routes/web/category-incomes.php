<?php

use App\Http\Controllers\CategoryIncomeController;
use Illuminate\Support\Facades\Route;

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
