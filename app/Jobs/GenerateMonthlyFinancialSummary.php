<?php

namespace App\Jobs;

use App\Mail\MonthlyFinancialSummaryMail;
use App\Models\Expense;
use App\Models\Income;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class GenerateMonthlyFinancialSummary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $now = CarbonImmutable::now();
        $monthStart = $now->subMonthNoOverflow()->startOfMonth()->toDateString();
        $monthEnd = $now->subMonthNoOverflow()->endOfMonth()->toDateString();

        $monthlyReportId = DB::table('monthly_reports')->where('month_start', $monthStart)->value('id');

        if ($monthlyReportId) {
            return;
        }

        $monthlyReportId = DB::table('monthly_reports')->insertGetId([
            'month_start' => $monthStart,
            'month_end' => $monthEnd,
            'total_expenses_amount' => 0,
            'total_incomes_amount' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $expenses = Expense::query()
            ->whereBetween('created_at', [CarbonImmutable::parse($monthStart)->startOfDay(), CarbonImmutable::parse($monthEnd)->endOfDay()])
            ->get();

        $incomes = Income::query()
            ->whereBetween('created_at', [CarbonImmutable::parse($monthStart)->startOfDay(), CarbonImmutable::parse($monthEnd)->endOfDay()])
            ->get();

        foreach ($expenses as $expense) {
            DB::table('monthly_report_expenses')->insert([
                'monthly_report_id' => $monthlyReportId,
                'expense_id' => $expense->id,
                'name' => $expense->name,
                'amount' => $expense->amount,
                'category_id' => $expense->category_id,
                'payment_method_id' => $expense->payment_method_id,
                'active' => $expense->active,
                'original_created_at' => $expense->created_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($incomes as $income) {
            DB::table('monthly_report_incomes')->insert([
                'monthly_report_id' => $monthlyReportId,
                'income_id' => $income->id,
                'name' => $income->name,
                'amount' => $income->amount,
                'category_income_id' => $income->category_income_id,
                'account_id' => $income->account_id,
                'original_created_at' => $income->created_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $expenseTotals = DB::table('monthly_report_expenses')
            ->selectRaw('category_id, SUM(amount) as total_amount')
            ->where('monthly_report_id', $monthlyReportId)
            ->groupBy('category_id')
            ->get();

        foreach ($expenseTotals as $row) {
            DB::table('monthly_report_expense_category_totals')->insert([
                'monthly_report_id' => $monthlyReportId,
                'category_id' => $row->category_id,
                'total_amount' => $row->total_amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $incomeTotals = DB::table('monthly_report_incomes')
            ->selectRaw('category_income_id, SUM(amount) as total_amount')
            ->where('monthly_report_id', $monthlyReportId)
            ->groupBy('category_income_id')
            ->get();

        foreach ($incomeTotals as $row) {
            DB::table('monthly_report_income_category_totals')->insert([
                'monthly_report_id' => $monthlyReportId,
                'category_income_id' => $row->category_income_id,
                'total_amount' => $row->total_amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $totalExpensesAmount = (float) DB::table('monthly_report_expenses')->where('monthly_report_id', $monthlyReportId)->sum('amount');
        $totalIncomesAmount = (float) DB::table('monthly_report_incomes')->where('monthly_report_id', $monthlyReportId)->sum('amount');

        DB::table('monthly_reports')->where('id', $monthlyReportId)->update([
            'total_expenses_amount' => $totalExpensesAmount,
            'total_incomes_amount' => $totalIncomesAmount,
            'updated_at' => now(),
        ]);

        $recipient = config('mail.from.address');
        Mail::to($recipient)->send(new MonthlyFinancialSummaryMail($monthlyReportId));
    }
}
