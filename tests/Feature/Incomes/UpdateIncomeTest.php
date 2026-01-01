<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view edit income page', function () {
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response = $this->get(route('incomes.edit', $income));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit income page', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    \App\Models\CategoryIncome::create(['name' => 'Alpha']);
    \App\Models\Account::create(['name' => 'A']);

    $response = $this->actingAs($user)->get(route('incomes.edit', $income));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Edit')
        ->where('income.id', $income->id)
        ->where('income.name', 'Salary')
        ->where('income.amount', '10.00')
        ->where('income.category_income_id', $categoryIncome->id)
        ->where('income.account_id', $account->id)
        ->where('income.update_url', route('incomes.update', $income, absolute: false))
        ->where('index_url', route('incomes.index', absolute: false))
        ->has('category_incomes')
        ->has('accounts')
    );
});

test('guests cannot update incomes', function () {
    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $newCategoryIncome = \App\Models\CategoryIncome::create(['name' => 'Bonus']);
    $newAccount = \App\Models\Account::create(['name' => 'Savings']);

    $response = $this->put(route('incomes.update', $income), [
        'name' => 'Bonus',
        'category_income_id' => $newCategoryIncome->id,
        'amount' => '20.00',
        'account_id' => $newAccount->id,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update incomes', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $newCategoryIncome = \App\Models\CategoryIncome::create(['name' => 'Bonus']);
    $newAccount = \App\Models\Account::create(['name' => 'Savings']);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => 'Bonus',
        'category_income_id' => $newCategoryIncome->id,
        'amount' => '20.00',
        'account_id' => $newAccount->id,
    ]);

    $response->assertRedirect(route('incomes.index'));

    $this->assertDatabaseHas('incomes', [
        'id' => $income->id,
        'name' => 'Bonus',
        'category_income_id' => $newCategoryIncome->id,
        'amount' => '20.00',
        'account_id' => $newAccount->id,
    ]);
});

test('income name is required when updating', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => '',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('income name must be less than 30 characters when updating', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => str_repeat('a', 30),
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('income name must be unique when updating', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $incomeA = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $incomeB = \App\Models\Income::create([
        'name' => 'Bonus',
        'category_income_id' => $categoryIncome->id,
        'amount' => '20.00',
        'account_id' => $account->id,
    ]);

    $response = $this->actingAs($user)->put(route('incomes.update', $incomeB), [
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '20.00',
        'account_id' => $account->id,
    ]);

    $response->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('incomes', [
        'id' => $incomeB->id,
        'name' => 'Bonus',
    ]);
});

test('updating an income with its current name is allowed', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $income = \App\Models\Income::create([
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response = $this->actingAs($user)->put(route('incomes.update', $income), [
        'name' => 'Salary',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);

    $response->assertRedirect(route('incomes.index'));
});
