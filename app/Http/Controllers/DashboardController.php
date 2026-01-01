<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Carbon\CarbonImmutable;
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

        $expenseChangePercent = $this->percentChange($prevMtdExpenses, $mtdExpenses);
        $incomeChangePercent = $this->percentChange($prevMtdIncomes, $mtdIncomes);

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

        return Inertia::render('Dashboard', [
            'kpis' => [
                'mtd_expenses' => $this->currency($mtdExpenses),
                'mtd_incomes' => $this->currency($mtdIncomes),
                'mtd_balance' => $this->currency($mtdBalance),
                'mtd_expenses_change_percent' => $expenseChangePercent,
                'mtd_incomes_change_percent' => $incomeChangePercent,
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
}
