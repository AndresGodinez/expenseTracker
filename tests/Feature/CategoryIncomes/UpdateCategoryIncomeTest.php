<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit income category page', function () {
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->get(route('category-incomes.edit', $categoryIncome));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit income category page', function () {
    $user = User::factory()->create();
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->get(route('category-incomes.edit', $categoryIncome));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('category-incomes/Edit')
        ->where('category_income.id', $categoryIncome->id)
        ->where('category_income.name', 'Salary')
        ->where('category_income.update_url', route('category-incomes.update', $categoryIncome, absolute: false))
        ->where('index_url', route('category-incomes.index', absolute: false))
    );
});

test('guests cannot update income categories', function () {
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->put(route('category-incomes.update', $categoryIncome), [
        'name' => 'Bonus',
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update income categories', function () {
    $user = User::factory()->create();
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('category-incomes.update', $categoryIncome), [
        'name' => 'Bonus',
    ]);

    $response->assertRedirect(route('category-incomes.index'));

    $this->assertDatabaseHas('category_incomes', [
        'id' => $categoryIncome->id,
        'name' => 'Bonus',
    ]);
});

test('income category name is required when updating', function () {
    $user = User::factory()->create();
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('category-incomes.update', $categoryIncome), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('income category name must be less than 30 characters when updating', function () {
    $user = User::factory()->create();
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('category-incomes.update', $categoryIncome), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('income category name must be unique when updating', function () {
    $user = User::factory()->create();

    $a = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $b = \App\Models\CategoryIncome::create(['name' => 'Bonus']);

    $response = $this->actingAs($user)->put(route('category-incomes.update', $b), [
        'name' => 'Salary',
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('category_incomes', [
        'id' => $b->id,
        'name' => 'Bonus',
    ]);
});

test('updating an income category with its current name is allowed', function () {
    $user = User::factory()->create();
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('category-incomes.update', $categoryIncome), [
        'name' => 'Salary',
    ]);

    $response->assertRedirect(route('category-incomes.index'));
});
