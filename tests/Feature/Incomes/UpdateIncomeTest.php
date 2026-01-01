<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit income page', function () {
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->get(route('incomes.edit', $income));

    $response->assertRedirect(route('login'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('authenticated users can view edit income page', function () {
    $user = User::factory()->create();
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->get(route('incomes.edit', $income));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Edit')
        ->where('income.id', $income->id)
        ->where('income.name', 'Salary')
        ->where('income.update_url', route('incomes.update', $income, absolute: false))
        ->where('index_url', route('incomes.index', absolute: false))
    );
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('guests cannot update incomes', function () {
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->put(route('incomes.update', $income), [
        'name' => 'Bonus',
    ]);

    $response->assertRedirect(route('login'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('authenticated users can update incomes', function () {
    $user = User::factory()->create();
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => 'Bonus',
    ]);

    $response->assertRedirect(route('incomes.index'));

    $this->assertDatabaseHas('incomes', [
        'id' => $income->id,
        'name' => 'Bonus',
    ]);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('income name is required when updating', function () {
    $user = User::factory()->create();
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('income name must be less than 30 characters when updating', function () {
    $user = User::factory()->create();
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('income name must be unique when updating', function () {
    $user = User::factory()->create();

    $incomeA = \App\Models\Income::create(['name' => 'Salary']);
    $incomeB = \App\Models\Income::create(['name' => 'Bonus']);

    $response = $this->actingAs($user)->put(route('incomes.update', $incomeB), [
        'name' => 'Salary',
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('incomes', [
        'id' => $incomeB->id,
        'name' => 'Bonus',
    ]);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('updating an income with its current name is allowed', function () {
    $user = User::factory()->create();
    $income = \App\Models\Income::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => 'Salary',
    ]);

    $response->assertRedirect(route('incomes.index'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');
