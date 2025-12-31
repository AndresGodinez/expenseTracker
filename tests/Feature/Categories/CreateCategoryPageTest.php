<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create category page', function () {
    $response = $this->get(route('categories.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create category page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('categories.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('categories/Create')
        ->where('store_url', route('categories.store', absolute: false))
    );
});
