<?php

use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

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
