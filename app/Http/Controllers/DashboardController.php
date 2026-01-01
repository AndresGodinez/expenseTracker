<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $now = CarbonImmutable::now();

        $currentStart = $now->startOfMonth()->startOfDay();
        $currentEnd = $now->endOfDay();

        $daysElapsed = $currentStart->diffInDays($currentEnd);

        $previousStart = $now->subMonthNoOverflow()->startOfMonth()->startOfDay();
        $previousEnd = $previousStart->addDays($daysElapsed)->endOfDay();

        if ($previousEnd->greaterThan($previousStart->endOfMonth()->endOfDay())) {
            $previousEnd = $previousStart->endOfMonth()->endOfDay();
        }

        $mtdExpenses = (float) Expense::query()->whereBetween('created_at', [$currentStart, $currentEnd])->sum('amount');
        $mtdIncomes = (float) Income::query()->whereBetween('created_at', [$currentStart, $currentEnd])->sum('amount');
        $mtdBalance = $mtdIncomes - $mtdExpenses;

        $prevMtdExpenses = (float) Expense::query()->whereBetween('created_at', [$previousStart, $previousEnd])->sum('amount');
        $prevMtdIncomes = (float) Income::query()->whereBetween('created_at', [$previousStart, $previousEnd])->sum('amount');
        $prevMtdBalance = $prevMtdIncomes - $prevMtdExpenses;

        $expenseChangePercent = $this->percentChange($prevMtdExpenses, $mtdExpenses);
        $incomeChangePercent = $this->percentChange($prevMtdIncomes, $mtdIncomes);
        $balanceChangePercent = $this->percentChange($prevMtdBalance, $mtdBalance);

        $expenseChangeAmount = $prevMtdExpenses == 0.0 ? null : $this->currency($mtdExpenses - $prevMtdExpenses);
        $incomeChangeAmount = $prevMtdIncomes == 0.0 ? null : $this->currency($mtdIncomes - $prevMtdIncomes);
        $balanceChangeAmount = $prevMtdBalance == 0.0 ? null : $this->currency($mtdBalance - $prevMtdBalance);

        $labels = [];
        $cursor = $currentStart;
        while ($cursor->lte($currentEnd)) {
            $labels[] = $cursor->toDateString();
            $cursor = $cursor->addDay();
        }

        $expenseByDay = Expense::query()
            ->selectRaw('DATE(created_at) as day, SUM(amount) as total')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->all();

        $incomeByDay = Income::query()
            ->selectRaw('DATE(created_at) as day, SUM(amount) as total')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->all();

        $expenseSeries = array_map(fn (string $day) => (float) ($expenseByDay[$day] ?? 0), $labels);
        $incomeSeries = array_map(fn (string $day) => (float) ($incomeByDay[$day] ?? 0), $labels);

        $totalExpenseAmountForMonth = $mtdExpenses;

        $expenseCategoryTotals = Expense::query()
            ->leftJoin('categories as c', 'c.id', '=', 'expenses.category_id')
            ->whereBetween('expenses.created_at', [$currentStart, $currentEnd])
            ->selectRaw("COALESCE(c.name, 'Uncategorized') as category, SUM(expenses.amount) as total")
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topExpenseCategories = $expenseCategoryTotals->map(function ($row) use ($totalExpenseAmountForMonth) {
            $total = (float) $row->total;
            $percent = $totalExpenseAmountForMonth == 0.0 ? null : (($total / $totalExpenseAmountForMonth) * 100);

            return [
                'category' => $row->category,
                'total_amount' => $this->currency($total),
                'percent' => $percent === null ? null : $this->percent($percent),
                'raw_total' => $total,
            ];
        });

        $trend = DB::table('monthly_reports')
            ->orderBy('month_start')
            ->limit(12)
            ->get(['month_start', 'total_expenses_amount', 'total_incomes_amount'])
            ->map(function ($row) {
                $expenses = (float) $row->total_expenses_amount;
                $incomes = (float) $row->total_incomes_amount;

                return [
                    'month' => CarbonImmutable::parse((string) $row->month_start)->toDateString(),
                    'expenses' => $expenses,
                    'incomes' => $incomes,
                    'balance' => $incomes - $expenses,
                ];
            });

        $trendLabels = $trend->pluck('month')->all();
        $trendExpenses = $trend->pluck('expenses')->all();
        $trendIncomes = $trend->pluck('incomes')->all();
        $trendBalance = $trend->pluck('balance')->all();

        return Inertia::render('Dashboard', [
            'kpis' => [
                'mtd_expenses' => $this->currency($mtdExpenses),
                'mtd_incomes' => $this->currency($mtdIncomes),
                'mtd_balance' => $this->currency($mtdBalance),
                'mtd_expenses_change_amount' => $expenseChangeAmount,
                'mtd_expenses_change_percent' => $expenseChangePercent,
                'mtd_incomes_change_amount' => $incomeChangeAmount,
                'mtd_incomes_change_percent' => $incomeChangePercent,
                'mtd_balance_change_amount' => $balanceChangeAmount,
                'mtd_balance_change_percent' => $balanceChangePercent,
                'range' => [
                    'current_start' => $currentStart->toDateString(),
                    'current_end' => $currentEnd->toDateString(),
                    'previous_start' => $previousStart->toDateString(),
                    'previous_end' => $previousEnd->toDateString(),
                ],
            ],
            'chart' => [
                'labels' => $labels,
                'expenses' => $expenseSeries,
                'incomes' => $incomeSeries,
            ],
            'top_expense_categories' => $topExpenseCategories,
            'top_expense_categories_chart' => [
                'labels' => $topExpenseCategories->pluck('category')->all(),
                'totals' => $topExpenseCategories->pluck('raw_total')->all(),
            ],
            'trend_12_months' => [
                'labels' => $trendLabels,
                'expenses' => $trendExpenses,
                'incomes' => $trendIncomes,
                'balance' => $trendBalance,
            ],
        ]);
    }

    private function currency(float $value): string
    {
        return '$'.str_replace(',', ' ', Number::format($value, 2));
    }

    private function percentChange(float $previous, float $current): ?string
    {
        if ($previous == 0.0) {
            return null;
        }

        $pct = (($current - $previous) / $previous) * 100;
        $formatted = Number::format($pct, 2);

        if ($pct > 0) {
            $formatted = '+'.$formatted;
        }

        return $formatted.'%';
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
