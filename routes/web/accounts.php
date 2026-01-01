<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

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
