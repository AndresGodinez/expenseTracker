<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class MonthlyFinancialSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public int $monthlyReportId,
    ) {
    }

    public function build(): self
    {
        $report = DB::table('monthly_reports')->where('id', $this->monthlyReportId)->first();

        $expenseTotals = DB::table('monthly_report_expense_category_totals')
            ->where('monthly_report_id', $this->monthlyReportId)
            ->orderByDesc('total_amount')
            ->get()
            ->map(function ($row) {
                $categoryName = null;

                if ($row->category_id !== null) {
                    $categoryName = DB::table('categories')->where('id', $row->category_id)->value('name');
                }

                return [
                    'category' => $categoryName ?? 'Uncategorized',
                    'total_amount' => '$'.str_replace(',', ' ', Number::format((float) $row->total_amount, 2)),
                ];
            });

        $totalExpenses = '$'.str_replace(',', ' ', Number::format((float) $report->total_expenses_amount, 2));

        return $this
            ->subject('Monthly financial summary')
            ->view('emails.monthly-financial-summary')
            ->with([
                'report' => $report,
                'total_expenses' => $totalExpenses,
                'expense_totals' => $expenseTotals,
            ]);
    }
}
