<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view create income page', function () {
    $response = $this->get(route('incomes.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create income page', function () {
    $user = User::factory()->create();

    \App\Models\CategoryIncome::create(['name' => 'Alpha']);
    \App\Models\CategoryIncome::create(['name' => 'Beta']);
    \App\Models\Account::create(['name' => 'A']);
    \App\Models\Account::create(['name' => 'B']);

    $response = $this->actingAs($user)->get(route('incomes.create'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Create')
        ->where('store_url', route('incomes.store', absolute: false))
        ->where('index_url', route('incomes.index', absolute: false))
        ->has('category_incomes', 2)
        ->where('category_incomes.0.name', 'Alpha')
        ->where('category_incomes.1.name', 'Beta')
        ->has('accounts', 2)
        ->where('accounts.0.name', 'A')
        ->where('accounts.1.name', 'B')
    );
});
