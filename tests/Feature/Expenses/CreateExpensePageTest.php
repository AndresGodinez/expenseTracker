<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create expense page', function () {
    $response = $this->get(route('expenses.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create expense page', function () {
    $user = User::factory()->create();

    \App\Models\Category::create(['name' => 'Food']);
    \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $response = $this->actingAs($user)->get(route('expenses.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('expenses/Create')
        ->where('store_url', route('expenses.store', absolute: false))
        ->where('index_url', route('expenses.index', absolute: false))
        ->has('categories', 1)
        ->has('payment_methods', 1)
    );
});
