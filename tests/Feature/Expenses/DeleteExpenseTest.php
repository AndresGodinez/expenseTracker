<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete expenses', function () {
    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response = $this->delete(route('expenses.destroy', $expense));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete expenses', function () {
    $user = User::factory()->create();

    $expense = \App\Models\Expense::create([
        'name' => 'Lunch',
        'amount' => '12.50',
        'active' => true,
    ]);

    $response = $this->actingAs($user)->delete(route('expenses.destroy', $expense));

    $response->assertRedirect(route('expenses.index'));

    $this->assertDatabaseMissing('expenses', [
        'id' => $expense->id,
    ]);
});
