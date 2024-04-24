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
        Schema::create('employee_benefit_histories', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('employee_benefit_id')->unsigned()->nullable();
            $table->decimal('before_health_care', 10, 2)->unsigned()->nullable();
            $table->decimal('after_health_care', 10, 2)->unsigned()->nullable();
            $table->decimal('before_vision', 10, 2)->unsigned()->nullable();
            $table->decimal('after_vision', 10, 2)->unsigned()->nullable();
            $table->decimal('before_dental', 10, 2)->unsigned()->nullable();
            $table->decimal('after_dental', 10, 2)->unsigned()->nullable();
            $table->decimal('before_pregnancy', 10, 2)->unsigned()->nullable();
            $table->decimal('after_pregnancy', 10, 2)->unsigned()->nullable();
            $table->text('note')->nullable();
            $table->text('file_path')->nullable();
            $table->mediumInteger('created_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_benefit_histories');
    }
};
