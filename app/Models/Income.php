<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'name',
        'category_income_id',
        'amount',
        'account_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function categoryIncome(): BelongsTo
    {
        return $this->belongsTo(CategoryIncome::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
