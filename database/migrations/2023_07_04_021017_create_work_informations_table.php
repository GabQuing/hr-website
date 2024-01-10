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
        Schema::create('work_informations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->length(10)->unsigned()->nullable();
            $table->integer('department_id')->length(10)->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->integer('employee_type_id')->length(10)->unsigned()->nullable();
            $table->string('immediate_supervisor')->nullable();
            $table->string('designated_work_place')->nullable();
            $table->integer('employment_status_id')->length(10)->unsigned()->nullable();
            $table->integer('user_type_id')->length(10)->unsigned()->nullable();
            $table->string('job_code')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('expected_regularization_date')->nullable();
            $table->string('regularization_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_informations');
    }
};
