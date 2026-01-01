<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreign('category_income_id')->references('id')->on('category_incomes');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign(['category_income_id']);
            $table->dropForeign(['account_id']);
        });
    }
};
