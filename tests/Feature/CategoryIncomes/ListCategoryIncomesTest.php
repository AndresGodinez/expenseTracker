<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view income categories', function () {
    $response = $this->get(route('category-incomes.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view income categories ordered by name', function () {
    $user = User::factory()->create();

    $zeta = \App\Models\CategoryIncome::create(['name' => 'Zeta']);
    $alpha = \App\Models\CategoryIncome::create(['name' => 'Alpha']);
    $beta = \App\Models\CategoryIncome::create(['name' => 'Beta']);

    $response = $this->actingAs($user)->get(route('category-incomes.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('category-incomes/Index')
        ->has('category_incomes', 3)
        ->where('create_url', route('category-incomes.create', absolute: false))
        ->where('category_incomes.0.name', 'Alpha')
        ->where('category_incomes.0.edit_url', route('category-incomes.edit', $alpha, absolute: false))
        ->where('category_incomes.0.destroy_url', route('category-incomes.destroy', $alpha, absolute: false))
        ->where('category_incomes.1.name', 'Beta')
        ->where('category_incomes.1.edit_url', route('category-incomes.edit', $beta, absolute: false))
        ->where('category_incomes.1.destroy_url', route('category-incomes.destroy', $beta, absolute: false))
        ->where('category_incomes.2.name', 'Zeta')
        ->where('category_incomes.2.edit_url', route('category-incomes.edit', $zeta, absolute: false))
        ->where('category_incomes.2.destroy_url', route('category-incomes.destroy', $zeta, absolute: false))
    );
});
