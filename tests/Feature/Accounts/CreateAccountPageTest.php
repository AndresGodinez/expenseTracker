<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create account page', function () {
    $response = $this->get(route('accounts.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create account page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('accounts.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('accounts/Create')
        ->where('store_url', route('accounts.store', absolute: false))
        ->where('index_url', route('accounts.index', absolute: false))
    );
});
