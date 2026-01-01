<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function incomePayload(array $overrides = []): array
{
    $categoryIncomeId = $overrides['category_income_id'] ?? \App\Models\CategoryIncome::create(['name' => 'Salary'])->id;
    $accountId = $overrides['account_id'] ?? \App\Models\Account::create(['name' => 'Checking'])->id;

    return array_merge([
        'name' => 'Salary',
        'category_income_id' => $categoryIncomeId,
        'amount' => '100.00',
        'account_id' => $accountId,
    ], $overrides);
}

test('authenticated users can create an income', function () {
    $user = User::factory()->create();

    $payload = incomePayload();

    $response = $this->actingAs($user)->post(route('incomes.store'), $payload);

    $response->assertRedirect(route('incomes.index'));

    $this->assertDatabaseHas('incomes', [
        'name' => $payload['name'],
        'category_income_id' => $payload['category_income_id'],
        'amount' => $payload['amount'],
        'account_id' => $payload['account_id'],
    ]);
});

test('income name is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'name' => '',
    ]));

    $response->assertSessionHasErrors(['name']);
});

test('income name must be unique', function () {
    $user = User::factory()->create();

    $payload = incomePayload();

    $this->actingAs($user)->post(route('incomes.store'), $payload);

    $response = $this->actingAs($user)->post(route('incomes.store'), $payload);

    $response->assertSessionHasErrors(['name']);
});

test('income name must be less than 30 characters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'name' => str_repeat('a', 30),
    ]));

    $response->assertSessionHasErrors(['name']);
});

test('income category_income_id is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'category_income_id' => '',
    ]));

    $response->assertSessionHasErrors(['category_income_id']);
});

test('income category_income_id must exist', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'category_income_id' => 999,
    ]));

    $response->assertSessionHasErrors(['category_income_id']);
});

test('income account_id is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'account_id' => '',
    ]));

    $response->assertSessionHasErrors(['account_id']);
});

test('income account_id must exist', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'account_id' => 999,
    ]));

    $response->assertSessionHasErrors(['account_id']);
});

test('income amount is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'amount' => '',
    ]));

    $response->assertSessionHasErrors(['amount']);
});

test('income amount must be at most 999999.99', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('incomes.store'), incomePayload([
        'amount' => '1000000.00',
    ]));

    $response->assertSessionHasErrors(['amount']);
});

test('guests cannot create incomes', function () {
    $response = $this->post(route('incomes.store'), incomePayload());

    $response->assertRedirect(route('login'));
});
