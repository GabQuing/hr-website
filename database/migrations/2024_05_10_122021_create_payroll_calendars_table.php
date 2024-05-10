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
        Schema::create('payroll_calendars', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('calendar_year')->length(10);
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->smallInteger('created_by')->unsigned()->nullable();
            $table->smallInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_calendars');
    }
};
