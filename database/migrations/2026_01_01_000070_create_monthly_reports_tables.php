<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->date('month_start')->unique();
            $table->date('month_end');
            $table->decimal('total_expenses_amount', 12, 2)->default(0);
            $table->decimal('total_incomes_amount', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('monthly_report_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_report_id')->constrained('monthly_reports');
            $table->foreignId('expense_id')->nullable();
            $table->string('name', 29);
            $table->decimal('amount', 8, 2);
            $table->foreignId('category_id')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamp('original_created_at')->nullable();
            $table->timestamps();
        });

        Schema::create('monthly_report_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_report_id')->constrained('monthly_reports');
            $table->foreignId('income_id')->nullable();
            $table->string('name', 29);
            $table->decimal('amount', 8, 2);
            $table->foreignId('category_income_id');
            $table->foreignId('account_id');
            $table->timestamp('original_created_at')->nullable();
            $table->timestamps();
        });

        Schema::create('monthly_report_expense_category_totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_report_id')->constrained('monthly_reports');
            $table->foreignId('category_id')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();

            $table->unique(['monthly_report_id', 'category_id']);
        });

        Schema::create('monthly_report_income_category_totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_report_id')->constrained('monthly_reports');
            $table->foreignId('category_income_id');
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();

            $table->unique(['monthly_report_id', 'category_income_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_report_income_category_totals');
        Schema::dropIfExists('monthly_report_expense_category_totals');
        Schema::dropIfExists('monthly_report_incomes');
        Schema::dropIfExists('monthly_report_expenses');
        Schema::dropIfExists('monthly_reports');
    }
};
