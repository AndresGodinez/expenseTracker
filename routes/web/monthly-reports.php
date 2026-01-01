<?php

use App\Http\Controllers\MonthlyReportsController;
use Illuminate\Support\Facades\Route;

Route::get('monthly-reports', [MonthlyReportsController::class, 'index'])
    ->middleware('auth')
    ->name('monthly-reports.index');

Route::get('monthly-reports/{monthlyReport}', [MonthlyReportsController::class, 'show'])
    ->middleware('auth')
    ->name('monthly-reports.show');
