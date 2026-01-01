<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit expense page', function () {
    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response = $this->get(route('expenses.edit', $expense));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit expense page', function () {
    $user = User::factory()->create();

    $category = \App\Models\Category::create(['name' => 'Food']);
    $paymentMethod = \App\Models\PaymentMethod::create(['name' => 'Cash', 'active' => true]);

    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'category_id' => $category->id,
        'payment_method_id' => $paymentMethod->id,
        'active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('expenses.edit', $expense));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('expenses/Edit')
        ->where('index_url', route('expenses.index', absolute: false))
        ->where('expense.id', $expense->id)
        ->where('expense.name', 'Lunch')
        ->where('expense.amount', '12.50')
        ->where('expense.category_id', $category->id)
        ->where('expense.payment_method_id', $paymentMethod->id)
        ->where('expense.active', true)
        ->where('expense.update_url', route('expenses.update', $expense, absolute: false))
        ->has('categories', 1)
        ->has('payment_methods', 1)
    );
});

test('guests cannot update expenses', function () {
    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response = $this->put(route('expenses.update', $expense), [
        'name' => 'Dinner',
        'amount' => '20.00',
        'active' => false,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update expenses', function () {
    $user = User::factory()->create();

    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response = $this->actingAs($user)->put(route('expenses.update', $expense), [
        'name' => 'Dinner',
        'amount' => '20.00',
        'active' => false,
    ]);

    $response->assertRedirect(route('expenses.index'));

    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id,
        'name' => 'Dinner',
        'amount' => '20.00',
        'active' => 0,
    ]);
});

test('expense name is required when updating', function () {
    $user = User::factory()->create();

    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response = $this->actingAs($user)->put(route('expenses.update', $expense), [
        'name' => '',
        'amount' => '12.50',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('expense name must be unique when updating', function () {
    $user = User::factory()->create();

    $expenseA = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '10.00',
        'active' => true,
    ]);

    $expenseB = \App\Models\Expense::create([
        'name' => 'Dinner',
        'amount' => '20.00',
        'active' => true,
    ]);

    $response = $this->actingAs($user)->put(route('expenses.update', $expenseB), [
        'name' => 'Lunch',
        'amount' => '20.00',
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('expenses', [
        'id' => $expenseB->id,
        'name' => 'Dinner',
    ]);
});

test('updating an expense with its current name is allowed', function () {
    $user = User::factory()->create();

    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '10.00',
        'active' => true,
    ]);

    $response = $this->actingAs($user)->put(route('expenses.update', $expense), [
        'name' => 'Lunch',
        'amount' => '10.00',
    ]);

    $response->assertRedirect(route('expenses.index'));
});
