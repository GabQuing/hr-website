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
        Schema::create('employee_benefits', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('user_id')->unsigned()->nullable();
            $table->decimal('health_care')->unsigned()->length(18, 2)->nullable();
            $table->decimal('vision')->unsigned()->length(18, 2)->nullable();
            $table->decimal('dental')->unsigned()->length(18, 2)->nullable();
            $table->decimal('pregnancy')->unsigned()->length(18, 2)->nullable();
            $table->mediumInteger('created_by')->unsigned()->nullable();
            $table->mediumInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_benefits');
    }
};
