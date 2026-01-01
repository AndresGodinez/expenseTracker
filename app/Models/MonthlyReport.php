<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    protected $table = 'monthly_reports';

    protected $guarded = [];

    protected $casts = [
        'month_start' => 'date',
        'month_end' => 'date',
        'total_expenses_amount' => 'decimal:2',
        'total_incomes_amount' => 'decimal:2',
        'expenses_change_amount' => 'decimal:2',
        'expenses_change_percent' => 'decimal:2',
        'incomes_change_amount' => 'decimal:2',
        'incomes_change_percent' => 'decimal:2',
        'balance_change_amount' => 'decimal:2',
        'balance_change_percent' => 'decimal:2',
    ];
}
