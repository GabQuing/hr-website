<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employee_payrolls', function (Blueprint $table) {
            $table->date('pay_date')->nullable()->after('to_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_payrolls', function (Blueprint $table) {
            $table->dropColumn('pay_date');
        });
    }
};
