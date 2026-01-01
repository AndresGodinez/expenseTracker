<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete payment methods', function () {
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->delete(route('payment-methods.destroy', $paymentMethod));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete payment methods', function () {
    $user = User::factory()->create();
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->delete(route('payment-methods.destroy', $paymentMethod));

    $response->assertRedirect(route('payment-methods.index'));

    $this->assertDatabaseMissing('payment_methods', [
        'id' => $paymentMethod->id,
    ]);
});
