<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:29', 'unique:incomes,name'],
            'category_income_id' => ['required', 'integer', 'exists:category_incomes,id'],
            'amount' => ['required', 'numeric', 'min:0', 'max:999999.99', 'decimal:0,2'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
        ];
    }
}
