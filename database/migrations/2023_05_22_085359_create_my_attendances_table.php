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
        Schema::create('my_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_name')->nullable();
            $table->integer('days_present')->nullable();
            $table->integer('days_absent')->nullable();
            $table->integer('late_minutes')->nullable();
            $table->integer('undertime_minutes')->nullable();
            $table->integer('total_late')->nullable();
            $table->integer('total_hours')->nullable();
            $table->string('status')->default('ACTIVE')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_attendances');
    }
};
