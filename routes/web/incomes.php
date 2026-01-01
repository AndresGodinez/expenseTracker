<?php

use App\Http\Controllers\IncomeController;
use Illuminate\Support\Facades\Route;

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
