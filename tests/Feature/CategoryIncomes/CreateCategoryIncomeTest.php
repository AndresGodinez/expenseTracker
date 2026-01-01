<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can create an income category', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('category-incomes.store'), [
        'name' => 'Salary',
    ]);

    $response->assertRedirect(route('category-incomes.index'));

    $this->assertDatabaseHas('category_incomes', [
        'name' => 'Salary',
    ]);
});

test('income category name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('category-incomes.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('income category name must be unique', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('category-incomes.store'), [
        'name' => 'Salary',
    ]);

    $response = $this->actingAs($user)->post(route('category-incomes.store'), [
        'name' => 'Salary',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('income category name must be less than 30 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('category-incomes.store'), [
        'name' => str_repeat('a', 30),
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('guests cannot create income categories', function () {
    $response = $this->post(route('category-incomes.store'), [
        'name' => 'Salary',
    ]);

    $response->assertRedirect(route('login'));
});
