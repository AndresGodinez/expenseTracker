<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->route('payment_method');

        return [
            'name' => [
                'required',
                'string',
                'max:29',
                Rule::unique('payment_methods', 'name')->ignore($paymentMethod),
            ],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
