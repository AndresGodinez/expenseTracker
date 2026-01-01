<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create income page', function () {
    $response = $this->get(route('incomes.create'));

    $response->assertRedirect(route('login'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('authenticated users can view create income page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('incomes.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Create')
        ->where('store_url', route('incomes.store', absolute: false))
        ->where('index_url', route('incomes.index', absolute: false))
    );
})->skip('Legacy incomes scaffold replaced by category-incomes.');
