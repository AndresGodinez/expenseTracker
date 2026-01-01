<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            $table->decimal('expenses_change_amount', 12, 2)->nullable()->after('total_incomes_amount');
            $table->decimal('expenses_change_percent', 7, 2)->nullable()->after('expenses_change_amount');
            $table->decimal('incomes_change_amount', 12, 2)->nullable()->after('expenses_change_percent');
            $table->decimal('incomes_change_percent', 7, 2)->nullable()->after('incomes_change_amount');
            $table->decimal('balance_change_amount', 12, 2)->nullable()->after('incomes_change_percent');
            $table->decimal('balance_change_percent', 7, 2)->nullable()->after('balance_change_amount');
        });
    }

    public function down(): void
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            $table->dropColumn([
                'expenses_change_amount',
                'expenses_change_percent',
                'incomes_change_amount',
                'incomes_change_percent',
                'balance_change_amount',
                'balance_change_percent',
            ]);
        });
    }
};
