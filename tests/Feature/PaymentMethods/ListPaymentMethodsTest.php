<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view payment methods', function () {
    $response = $this->get(route('payment-methods.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view payment methods ordered by name', function () {
    $user = User::factory()->create();

    $zeta = \App\Models\PaymentMethod::create(['name' => 'Zeta', 'active' => true]);
    $alpha = \App\Models\PaymentMethod::create(['name' => 'Alpha', 'active' => true]);
    $beta = \App\Models\PaymentMethod::create(['name' => 'Beta', 'active' => false]);

    $response = $this->actingAs($user)->get(route('payment-methods.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('payment-methods/Index')
        ->where('create_url', route('payment-methods.create', absolute: false))
        ->has('payment_methods', 3)
        ->where('payment_methods.0.name', 'Alpha')
        ->where('payment_methods.0.active', true)
        ->where('payment_methods.0.edit_url', route('payment-methods.edit', $alpha, absolute: false))
        ->where('payment_methods.0.destroy_url', route('payment-methods.destroy', $alpha, absolute: false))
        ->where('payment_methods.1.name', 'Beta')
        ->where('payment_methods.1.active', false)
        ->where('payment_methods.1.edit_url', route('payment-methods.edit', $beta, absolute: false))
        ->where('payment_methods.1.destroy_url', route('payment-methods.destroy', $beta, absolute: false))
        ->where('payment_methods.2.name', 'Zeta')
        ->where('payment_methods.2.active', true)
        ->where('payment_methods.2.edit_url', route('payment-methods.edit', $zeta, absolute: false))
        ->where('payment_methods.2.destroy_url', route('payment-methods.destroy', $zeta, absolute: false))
    );
});
