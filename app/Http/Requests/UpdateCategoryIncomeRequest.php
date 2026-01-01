<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryIncomeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:29',
                Rule::unique('category_incomes', 'name')->ignore($this->route('category_income')),
            ],
        ];
    }
}
