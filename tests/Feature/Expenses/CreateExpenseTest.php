<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot create expenses', function () {
    $response = $this->post(route('expenses.store'), [
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can create an expense', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response->assertRedirect(route('expenses.index'));

    $this->assertDatabaseHas('expenses', [
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => 1,
    ]);
});

test('expense name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => '',
        'amount' => '1.00',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('expense name must be unique', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Lunch',
        'amount' => '1.00',
    ]);

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Lunch',
        'amount' => '2.00',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('expense name must be less than 30 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => str_repeat('a', 30),
        'amount' => '1.00',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('expense amount is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Lunch',
        'amount' => '',
    ]);

    $response->assertSessionHasErrors(['amount']);
});

test('expense amount must be at most 999999.99', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Lunch',
        'amount' => '1000000.00',
    ]);

    $response->assertSessionHasErrors(['amount']);
});

test('expense active defaults to true when not provided', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Coffee',
        'amount' => '3.00',
    ]);

    $response->assertRedirect(route('expenses.index'));

    $this->assertDatabaseHas('expenses', [
        'name' => 'Coffee',
        'amount' => '3.00',
        'active' => 1,
    ]);
});

test('expense category_id must exist when provided', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Coffee',
        'amount' => '3.00',
        'category_id' => 999,
    ]);

    $response->assertSessionHasErrors(['category_id']);
});

test('expense payment_method_id must exist when provided', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('expenses.store'), [
        'name' => 'Coffee',
        'amount' => '3.00',
        'payment_method_id' => 999,
    ]);

    $response->assertSessionHasErrors(['payment_method_id']);
});
