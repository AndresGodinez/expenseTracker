<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create payment method page', function () {
    $response = $this->get(route('payment-methods.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create payment method page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('payment-methods.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('payment-methods/Create')
        ->where('store_url', route('payment-methods.store', absolute: false))
        ->where('index_url', route('payment-methods.index', absolute: false))
    );
});
