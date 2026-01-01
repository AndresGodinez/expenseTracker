<?php

use App\Models\Category;
use App\Models\CategoryIncome;
use App\Models\MonthlyReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $report = MonthlyReport::create([
        'month_start' => '2026-01-01',
        'month_end' => '2026-01-31',
        'total_expenses_amount' => '30.00',
        'total_incomes_amount' => '100.00',
    ]);

    $response = $this->get(route('monthly-reports.show', $report));
    $response->assertRedirect(route('login'));
});

test('authenticated users can view monthly report detail', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $report = MonthlyReport::create([
        'month_start' => '2026-01-01',
        'month_end' => '2026-01-31',
        'total_expenses_amount' => '30.00',
        'total_incomes_amount' => '100.00',
        'expenses_change_amount' => '10.00',
        'expenses_change_percent' => '50.00',
        'incomes_change_amount' => '20.00',
        'incomes_change_percent' => '25.00',
        'balance_change_amount' => '10.00',
        'balance_change_percent' => '16.67',
    ]);

    $food = Category::create(['name' => 'Food']);
    $salary = CategoryIncome::create(['name' => 'Salary']);

    DB::table('monthly_report_expense_category_totals')->insert([
        'monthly_report_id' => $report->id,
        'category_id' => $food->id,
        'total_amount' => '30.00',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('monthly_report_income_category_totals')->insert([
        'monthly_report_id' => $report->id,
        'category_income_id' => $salary->id,
        'total_amount' => '100.00',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('monthly_report_expenses')->insert([
        'monthly_report_id' => $report->id,
        'expense_id' => null,
        'name' => 'E1',
        'amount' => '30.00',
        'category_id' => $food->id,
        'payment_method_id' => null,
        'active' => true,
        'original_created_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('monthly_report_incomes')->insert([
        'monthly_report_id' => $report->id,
        'income_id' => null,
        'name' => 'I1',
        'amount' => '100.00',
        'category_income_id' => $salary->id,
        'account_id' => 1,
        'original_created_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->get(route('monthly-reports.show', $report));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('monthly-reports/Show')
        ->where('report.total_expenses_amount', '$30.00')
        ->where('report.total_incomes_amount', '$100.00')
        ->where('report.balance_amount', '$70.00')
        ->where('report.expenses_change_amount', '$10.00')
        ->where('report.expenses_change_percent', '+50.00%')
        ->has('expense_category_totals', 1)
        ->where('expense_category_totals.0.category', 'Food')
        ->where('expense_category_totals.0.total_amount', '$30.00')
        ->has('income_category_totals', 1)
        ->where('income_category_totals.0.category', 'Salary')
        ->where('income_category_totals.0.total_amount', '$100.00')
        ->has('expense_snapshots', 1)
        ->where('expense_snapshots.0.name', 'E1')
        ->where('expense_snapshots.0.amount', '$30.00')
        ->has('income_snapshots', 1)
        ->where('income_snapshots.0.name', 'I1')
        ->where('income_snapshots.0.amount', '$100.00')
    );
});
