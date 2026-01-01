<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Inertia\Inertia;

class MonthlyReportsController extends Controller
{
    public function index()
    {
        $reports = MonthlyReport::query()
            ->orderByDesc('month_start')
            ->limit(12)
            ->get()
            ->map(fn (MonthlyReport $report) => [
                'id' => $report->id,
                'month_start' => optional($report->month_start)->toDateString(),
                'month_end' => optional($report->month_end)->toDateString(),
                'total_expenses_amount' => $this->currency((float) $report->total_expenses_amount),
                'total_incomes_amount' => $this->currency((float) $report->total_incomes_amount),
                'balance_amount' => $this->currency(((float) $report->total_incomes_amount) - ((float) $report->total_expenses_amount)),
                'expenses_change_amount' => $report->expenses_change_amount === null ? null : $this->currency((float) $report->expenses_change_amount),
                'expenses_change_percent' => $report->expenses_change_percent === null ? null : $this->percent((float) $report->expenses_change_percent),
                'incomes_change_amount' => $report->incomes_change_amount === null ? null : $this->currency((float) $report->incomes_change_amount),
                'incomes_change_percent' => $report->incomes_change_percent === null ? null : $this->percent((float) $report->incomes_change_percent),
                'balance_change_amount' => $report->balance_change_amount === null ? null : $this->currency((float) $report->balance_change_amount),
                'balance_change_percent' => $report->balance_change_percent === null ? null : $this->percent((float) $report->balance_change_percent),
                'show_url' => route('monthly-reports.show', $report, absolute: false),
            ]);

        return Inertia::render('monthly-reports/Index', [
            'reports' => $reports,
        ]);
    }

    public function show(MonthlyReport $monthlyReport)
    {
        $expenseCategoryTotals = DB::table('monthly_report_expense_category_totals as totals')
            ->leftJoin('categories as c', 'c.id', '=', 'totals.category_id')
            ->where('totals.monthly_report_id', $monthlyReport->id)
            ->orderByDesc('totals.total_amount')
            ->get([
                'totals.category_id',
                'c.name as category_name',
                'totals.total_amount',
            ])
            ->map(fn ($row) => [
                'category' => $row->category_name ?? 'Uncategorized',
                'total_amount' => $this->currency((float) $row->total_amount),
            ]);

        $incomeCategoryTotals = DB::table('monthly_report_income_category_totals as totals')
            ->leftJoin('category_incomes as c', 'c.id', '=', 'totals.category_income_id')
            ->where('totals.monthly_report_id', $monthlyReport->id)
            ->orderByDesc('totals.total_amount')
            ->get([
                'totals.category_income_id',
                'c.name as category_name',
                'totals.total_amount',
            ])
            ->map(fn ($row) => [
                'category' => $row->category_name ?? 'Uncategorized',
                'total_amount' => $this->currency((float) $row->total_amount),
            ]);

        $expenseSnapshots = DB::table('monthly_report_expenses')
            ->where('monthly_report_id', $monthlyReport->id)
            ->orderByDesc('amount')
            ->limit(50)
            ->get([
                'name',
                'amount',
            ])
            ->map(fn ($row) => [
                'name' => $row->name,
                'amount' => $this->currency((float) $row->amount),
            ]);

        $incomeSnapshots = DB::table('monthly_report_incomes')
            ->where('monthly_report_id', $monthlyReport->id)
            ->orderByDesc('amount')
            ->limit(50)
            ->get([
                'name',
                'amount',
            ])
            ->map(fn ($row) => [
                'name' => $row->name,
                'amount' => $this->currency((float) $row->amount),
            ]);

        $totalExpenses = (float) $monthlyReport->total_expenses_amount;
        $totalIncomes = (float) $monthlyReport->total_incomes_amount;
        $balance = $totalIncomes - $totalExpenses;

        return Inertia::render('monthly-reports/Show', [
            'report' => [
                'id' => $monthlyReport->id,
                'month_start' => optional($monthlyReport->month_start)->toDateString(),
                'month_end' => optional($monthlyReport->month_end)->toDateString(),
                'total_expenses_amount' => $this->currency($totalExpenses),
                'total_incomes_amount' => $this->currency($totalIncomes),
                'balance_amount' => $this->currency($balance),
                'expenses_change_amount' => $monthlyReport->expenses_change_amount === null ? null : $this->currency((float) $monthlyReport->expenses_change_amount),
                'expenses_change_percent' => $monthlyReport->expenses_change_percent === null ? null : $this->percent((float) $monthlyReport->expenses_change_percent),
                'incomes_change_amount' => $monthlyReport->incomes_change_amount === null ? null : $this->currency((float) $monthlyReport->incomes_change_amount),
                'incomes_change_percent' => $monthlyReport->incomes_change_percent === null ? null : $this->percent((float) $monthlyReport->incomes_change_percent),
                'balance_change_amount' => $monthlyReport->balance_change_amount === null ? null : $this->currency((float) $monthlyReport->balance_change_amount),
                'balance_change_percent' => $monthlyReport->balance_change_percent === null ? null : $this->percent((float) $monthlyReport->balance_change_percent),
            ],
            'expense_category_totals' => $expenseCategoryTotals,
            'income_category_totals' => $incomeCategoryTotals,
            'expense_snapshots' => $expenseSnapshots,
            'income_snapshots' => $incomeSnapshots,
            'index_url' => route('monthly-reports.index', absolute: false),
        ]);
    }

    private function currency(float $value): string
    {
        return '$'.str_replace(',', ' ', Number::format($value, 2));
    }

    private function percent(float $value): string
    {
        $formatted = Number::format($value, 2);

        if ($value > 0) {
            $formatted = '+'.$formatted;
        }

        return $formatted.'%';
    }
}
