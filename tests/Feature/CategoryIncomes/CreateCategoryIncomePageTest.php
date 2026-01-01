<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create income category page', function () {
    $response = $this->get(route('category-incomes.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create income category page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('category-incomes.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('category-incomes/Create')
        ->where('store_url', route('category-incomes.store', absolute: false))
        ->where('index_url', route('category-incomes.index', absolute: false))
    );
});
