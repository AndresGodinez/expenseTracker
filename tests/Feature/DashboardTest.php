<?php

use App\Models\User;
use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Income;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
});

test('dashboard shows month-to-date KPIs and percent change vs previous month', function () {
    Carbon::setTestNow(Carbon::parse('2026-02-10 12:00:00'));

    $user = User::factory()->create();
    $this->actingAs($user);

    $categoryIncome = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    $expenseCurrent = Expense::create([
        'name' => 'Current expense',
        'amount' => '10.00',
        'active' => true,
    ]);
    $expenseCurrent->timestamps = false;
    $expenseCurrent->created_at = Carbon::parse('2026-02-05 10:00:00');
    $expenseCurrent->save();

    $incomeCurrent = Income::create([
        'name' => 'Current income',
        'category_income_id' => $categoryIncome->id,
        'amount' => '50.00',
        'account_id' => $account->id,
    ]);
    $incomeCurrent->timestamps = false;
    $incomeCurrent->created_at = Carbon::parse('2026-02-03 10:00:00');
    $incomeCurrent->save();

    $expensePrev = Expense::create([
        'name' => 'Prev expense',
        'amount' => '20.00',
        'active' => true,
    ]);
    $expensePrev->timestamps = false;
    $expensePrev->created_at = Carbon::parse('2026-01-05 10:00:00');
    $expensePrev->save();

    $incomePrev = Income::create([
        'name' => 'Prev income',
        'category_income_id' => $categoryIncome->id,
        'amount' => '25.00',
        'account_id' => $account->id,
    ]);
    $incomePrev->timestamps = false;
    $incomePrev->created_at = Carbon::parse('2026-01-03 10:00:00');
    $incomePrev->save();

    $response = $this->get(route('dashboard'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Dashboard')
        ->where('kpis.mtd_expenses', '$10.00')
        ->where('kpis.mtd_incomes', '$50.00')
        ->where('kpis.mtd_balance', '$40.00')
        ->where('kpis.mtd_expenses_change_percent', '-50.00%')
        ->where('kpis.mtd_incomes_change_percent', '+100.00%')
        ->where('chart.labels.0', '2026-02-01')
        ->where('chart.labels.9', '2026-02-10')
        ->where('chart.expenses.4', 10)
        ->where('chart.incomes.2', 50)
    );
});