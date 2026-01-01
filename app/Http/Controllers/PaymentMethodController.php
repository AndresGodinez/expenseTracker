<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use Inertia\Inertia;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::query()
            ->orderBy('name')
            ->get(['id', 'name', 'active'])
            ->map(fn (PaymentMethod $paymentMethod) => [
                'id' => $paymentMethod->id,
                'name' => $paymentMethod->name,
                'active' => $paymentMethod->active,
                'edit_url' => route('payment-methods.edit', $paymentMethod, absolute: false),
                'destroy_url' => route('payment-methods.destroy', $paymentMethod, absolute: false),
            ]);

        return Inertia::render('payment-methods/Index', [
            'payment_methods' => $paymentMethods,
            'create_url' => route('payment-methods.create', absolute: false),
        ]);
    }

    public function create()
    {
        return Inertia::render('payment-methods/Create', [
            'store_url' => route('payment-methods.store', absolute: false),
            'index_url' => route('payment-methods.index', absolute: false),
        ]);
    }

    public function store(StorePaymentMethodRequest $request)
    {
        $validated = $request->validated();

        if (! array_key_exists('active', $validated)) {
            $validated['active'] = true;
        }

        PaymentMethod::create($validated);

        return redirect()->route('payment-methods.index');
    }

    public function edit(PaymentMethod $payment_method)
    {
        return Inertia::render('payment-methods/Edit', [
            'payment_method' => [
                'id' => $payment_method->id,
                'name' => $payment_method->name,
                'active' => $payment_method->active,
                'update_url' => route('payment-methods.update', $payment_method, absolute: false),
            ],
            'index_url' => route('payment-methods.index', absolute: false),
        ]);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        $validated = $request->validated();

        $payment_method->update([
            'name' => $validated['name'],
            'active' => $validated['active'] ?? $payment_method->active,
        ]);

        return redirect()->route('payment-methods.index');
    }

    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();

        return redirect()->route('payment-methods.index');
    }
}
