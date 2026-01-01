<?php

use App\Jobs\GenerateMonthlyFinancialSummary;
use App\Mail\MonthlyFinancialSummaryMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('monthly financial summary job snapshots previous month data, stores category totals, and sends an email', function () {
    Mail::fake();

    User::factory()->create([
        'email' => 'owner@example.com',
    ]);

    $categoryA = \App\Models\Category::create(['name' => 'Food']);
    $categoryB = \App\Models\Category::create(['name' => 'Transport']);

    $categoryIncomeA = \App\Models\CategoryIncome::create(['name' => 'Salary']);
    $account = \App\Models\Account::create(['name' => 'Checking']);

    Carbon::setTestNow(Carbon::parse('2026-02-01 00:00:00'));

    $expense1 = \App\Models\Expense::create([
        'name' => 'E1',
        'amount' => '10.00',
        'category_id' => $categoryA->id,
        'payment_method_id' => null,
        'active' => true,
    ]);
    $expense1->timestamps = false;
    $expense1->created_at = Carbon::parse('2026-01-10 10:00:00');
    $expense1->save();

    $expense2 = \App\Models\Expense::create([
        'name' => 'E2',
        'amount' => '20.00',
        'category_id' => $categoryB->id,
        'payment_method_id' => null,
        'active' => true,
    ]);
    $expense2->timestamps = false;
    $expense2->created_at = Carbon::parse('2026-01-20 10:00:00');
    $expense2->save();

    $expenseOutside = \App\Models\Expense::create([
        'name' => 'E0',
        'amount' => '999.00',
        'category_id' => $categoryA->id,
        'payment_method_id' => null,
        'active' => true,
    ]);
    $expenseOutside->timestamps = false;
    $expenseOutside->created_at = Carbon::parse('2026-02-01 10:00:00');
    $expenseOutside->save();

    $income1 = \App\Models\Income::create([
        'name' => 'I1',
        'category_income_id' => $categoryIncomeA->id,
        'amount' => '100.00',
        'account_id' => $account->id,
    ]);
    $income1->timestamps = false;
    $income1->created_at = Carbon::parse('2026-01-05 10:00:00');
    $income1->save();

    (new GenerateMonthlyFinancialSummary())->handle();

    $this->assertDatabaseHas('monthly_reports', [
        'month_start' => '2026-01-01',
        'month_end' => '2026-01-31',
    ]);

    $monthlyReportId = \Illuminate\Support\Facades\DB::table('monthly_reports')->where('month_start', '2026-01-01')->value('id');

    $this->assertDatabaseHas('monthly_reports', [
        'id' => $monthlyReportId,
        'total_expenses_amount' => '30.00',
        'total_incomes_amount' => '100.00',
    ]);

    $this->assertDatabaseCount('monthly_report_expenses', 2);
    $this->assertDatabaseCount('monthly_report_incomes', 1);

    $this->assertDatabaseHas('monthly_report_expense_category_totals', [
        'monthly_report_id' => $monthlyReportId,
        'category_id' => $categoryA->id,
        'total_amount' => '10.00',
    ]);

    $this->assertDatabaseHas('monthly_report_expense_category_totals', [
        'monthly_report_id' => $monthlyReportId,
        'category_id' => $categoryB->id,
        'total_amount' => '20.00',
    ]);

    $this->assertDatabaseHas('monthly_report_income_category_totals', [
        'monthly_report_id' => $monthlyReportId,
        'category_income_id' => $categoryIncomeA->id,
        'total_amount' => '100.00',
    ]);

    Mail::assertSent(MonthlyFinancialSummaryMail::class, function (MonthlyFinancialSummaryMail $mail) {
        $html = $mail->render();

        expect($html)->toContain('Has gastado');
        expect($html)->toContain('$30.00');
        expect($html)->toContain('Food');
        expect($html)->toContain('Transport');

        return true;
    });
});
