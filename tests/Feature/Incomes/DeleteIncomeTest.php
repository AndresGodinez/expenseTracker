<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot delete incomes', function () {
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response = $this->delete(route('incomes.destroy', $income));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete incomes', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response = $this->actingAs($user)->delete(route('incomes.destroy', $income));

    $response->assertRedirect(route('incomes.index'));

    $this->assertDatabaseMissing('incomes', [
        'id' => $income->id,
    ]);
});
