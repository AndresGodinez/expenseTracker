<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit payment method page', function () {
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->get(route('payment-methods.edit', $paymentMethod));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit payment method page', function () {
    $user = User::factory()->create();
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->get(route('payment-methods.edit', $paymentMethod));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('payment-methods/Edit')
        ->where('index_url', route('payment-methods.index', absolute: false))
        ->where('payment_method.id', $paymentMethod->id)
        ->where('payment_method.name', 'Cash')
        ->where('payment_method.active', true)
        ->where('payment_method.update_url', route('payment-methods.update', $paymentMethod, absolute: false))
    );
});

test('guests cannot update payment methods', function () {
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->put(route('payment-methods.update', $paymentMethod), [
        'name' => 'Card',
        'active' => false,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update payment methods', function () {
    $user = User::factory()->create();
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->put(route('payment-methods.update', $paymentMethod), [
        'name' => 'Card',
        'active' => false,
    ]);

    $response->assertRedirect(route('payment-methods.index'));

    $this->assertDatabaseHas('payment_methods', [
        'id' => $paymentMethod->id,
        'name' => 'Card',
        'active' => 0,
    ]);
});

test('payment method name is required when updating', function () {
    $user = User::factory()->create();
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->put(route('payment-methods.update', $paymentMethod), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('payment method name must be less than 30 characters when updating', function () {
    $user = User::factory()->create();
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->put(route('payment-methods.update', $paymentMethod), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('payment method name must be unique when updating', function () {
    $user = User::factory()->create();

    $paymentMethodA = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);
    $paymentMethodB = \App\Models\PaymentMethod::create(['name' => 'Card', 'active' => true]);

    $response = $this->actingAs($user)->put(route('payment-methods.update', $paymentMethodB), [
        'name' => 'Cash',
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('payment_methods', [
        'id' => $paymentMethodB->id,
        'name' => 'Card',
    ]);
});

test('updating a payment method with its current name is allowed', function () {
    $user = User::factory()->create();
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->put(route('payment-methods.update', $paymentMethod), [
        'name' => 'Cash',
    ]);

    $response->assertRedirect(route('payment-methods.index'));
});
