<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:29',
                Rule::unique('expenses', 'name')->ignore($this->route('expense')),
            ],
            'amount' => ['required', 'numeric', 'min:0', 'max:999999.99', 'decimal:0,2'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
