<?php

use App\Models\MonthlyReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('monthly-reports.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can view monthly reports index (last 12)', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    MonthlyReport::create([
        'month_start' => '2026-01-01',
        'month_end' => '2026-01-31',
        'total_expenses_amount' => '30.00',
        'total_incomes_amount' => '100.00',
        'expenses_change_amount' => null,
        'expenses_change_percent' => null,
        'incomes_change_amount' => null,
        'incomes_change_percent' => null,
        'balance_change_amount' => null,
        'balance_change_percent' => null,
    ]);

    $response = $this->get(route('monthly-reports.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('monthly-reports/Index')
        ->has('reports', 1)
        ->where('reports.0.total_expenses_amount', '$30.00')
        ->where('reports.0.total_incomes_amount', '$100.00')
        ->where('reports.0.balance_amount', '$70.00')
        ->where('reports.0.expenses_change_amount', null)
        ->where('reports.0.expenses_change_percent', null)
    );
});
