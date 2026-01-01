<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete income categories', function () {
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->delete(route('category-incomes.destroy', $categoryIncome));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete income categories', function () {
    $user = User::factory()->create();
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);

    $response = $this->actingAs($user)->delete(route('category-incomes.destroy', $categoryIncome));

    $response->assertRedirect(route('category-incomes.index'));

    $this->assertDatabaseMissing('category_incomes', [
        'id' => $categoryIncome->id,
    ]);
});
