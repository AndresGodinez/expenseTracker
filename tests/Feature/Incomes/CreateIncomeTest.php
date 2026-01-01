<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can create an income', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), [
        'name' => 'Salary',
    ]);

    $response->assertRedirect(route('incomes.index'));

    $this->assertDatabaseHas('incomes', [
        'name' => 'Salary',
    ]);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('income name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('income name must be unique', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('incomes.store'), [
        'name' => 'Salary',
    ]);

    $response = $this->actingAs($user)->post(route('incomes.store'), [
        'name' => 'Salary',
    ]);

    $response->assertSessionHasErrors(['name']);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('income name must be less than 30 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
})->skip('Legacy incomes scaffold replaced by category-incomes.');

test('guests cannot create incomes', function () {
    $response = $this->post(route('incomes.store'), [
        'name' => 'Salary',
    ]);

    $response->assertRedirect(route('login'));
})->skip('Legacy incomes scaffold replaced by category-incomes.');
