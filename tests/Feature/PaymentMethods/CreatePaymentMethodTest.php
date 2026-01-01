<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot create payment methods', function () {
    $response = $this->post(route('payment-methods.store'), [
        'name' => 'Cash',
        'active' => true,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can create a payment method', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('payment-methods.store'), [
        'name' => 'Cash',
        'active' => true,
    ]);

    $response->assertRedirect(route('payment-methods.index'));

    $this->assertDatabaseHas('payment_methods', [
        'name' => 'Cash',
        'active' => 1,
    ]);
});

test('payment method name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('payment-methods.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('payment method name must be unique', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('payment-methods.store'), [
        'name' => 'Cash',
        'active' => true,
    ]);

    $response = $this->actingAs($user)->post(route('payment-methods.store'), [
        'name' => 'Cash',
        'active' => true,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('payment method name must be less than 30 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('payment-methods.store'), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('payment method active defaults to true when not provided', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('payment-methods.store'), [
        'name' => 'Card',
    ]);

    $response->assertRedirect(route('payment-methods.index'));

    $this->assertDatabaseHas('payment_methods', [
        'name' => 'Card',
        'active' => 1,
    ]);
});
