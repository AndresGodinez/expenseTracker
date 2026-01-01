<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('guests cannot view incomes', function () {
    $response = $this->get(route('incomes.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view incomes ordered by created_at desc', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $older = \App\Models\Income::create([
        'name' => 'Older',
        'category_income_id' => $categoryIncome->id,
        'amount' => '10.00',
        'account_id' => $account->id,
    ]);
    $older->timestamps = false;
    $older->created_at = now()->subDay();
    $older->save();

    $newer = \App\Models\Income::create([
        'name' => 'Newer',
        'category_income_id' => $categoryIncome->id,
        'amount' => '20.00',
        'account_id' => $account->id,
    ]);
    $newer->timestamps = false;
    $newer->created_at = now();
    $newer->save();

    $response = $this->actingAs($user)->get(route('incomes.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Index')
        ->where('create_url', route('incomes.create', absolute: false))
        ->where('index_url', route('incomes.index', absolute: false))
        ->where('filters.per_page', 15)
        ->where('incomes.data.0.name', 'Newer')
        ->where('incomes.data.0.edit_url', route('incomes.edit', $newer, absolute: false))
        ->where('incomes.data.0.destroy_url', route('incomes.destroy', $newer, absolute: false))
        ->where('incomes.data.1.name', 'Older')
        ->where('page_total_amount', '30.00')
    );
});

test('incomes index supports per_page pagination and includes per_page_options', function () {
    $user = User::factory()->create();

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    for ($i = 1; $i <= 16; $i++) {
        \App\Models\Income::create([
            'name' => 'Income '.$i,
            'category_income_id' => $categoryIncome->id,
            'amount' => '1.00',
            'account_id' => $account->id,
        ]);
    }

    $response = $this->actingAs($user)->get(route('incomes.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Index')
        ->where('filters.per_page', 15)
        ->has('incomes.data', 15)
        ->where('incomes.total', 16)
        ->where('per_page_options.0', 15)
        ->where('per_page_options.1', 30)
        ->where('per_page_options.2', 50)
        ->where('per_page_options.3', 100)
        ->where('page_total_amount', '15.00')
    );

    $response2 = $this->actingAs($user)->get(route('incomes.index', ['per_page' => 30]));

    $response2->assertOk();

    $response2->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Index')
        ->where('filters.per_page', 30)
        ->has('incomes.data', 16)
        ->where('page_total_amount', '16.00')
    );
});

test('incomes index can filter by category income and account and totals reflect filtered page', function () {
    $user = User::factory()->create();

    $categoryIncomeA = \App\Models\CategoryIncome::create(['name' => 'Alpha']);
    $categoryIncomeB = \App\Models\CategoryIncome::create(['name' => 'Beta']);
    $accountA = \App\Models\Account::create(['name' => 'A']);
    $accountB = \App\Models\Account::create(['name' => 'B']);

    \App\Models\Income::create([
        'name' => 'I1',
        'category_income_id' => $categoryIncomeA->id,
        'amount' => '10.00',
        'account_id' => $accountA->id,
    ]);

    \App\Models\Income::create([
        'name' => 'I2',
        'category_income_id' => $categoryIncomeA->id,
        'amount' => '20.00',
        'account_id' => $accountB->id,
    ]);

    \App\Models\Income::create([
        'name' => 'I3',
        'category_income_id' => $categoryIncomeB->id,
        'amount' => '30.00',
        'account_id' => $accountA->id,
    ]);

    $response = $this->actingAs($user)->get(route('incomes.index', [
        'category_income_id' => $categoryIncomeA->id,
        'account_id' => $accountA->id,
        'per_page' => 15,
    ]));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('incomes/Index')
        ->where('filters.category_income_id', $categoryIncomeA->id)
        ->where('filters.account_id', $accountA->id)
        ->has('incomes.data', 1)
        ->where('incomes.data.0.name', 'I1')
        ->where('page_total_amount', '10.00')
    );
});
