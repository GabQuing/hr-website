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
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('user_id')->nullable()->unsigned();
            $table->string('leave_type')->length(50)->nullable();
            $table->decimal('leave_credit', 10, 2)->unsigned()->nullable();
            $table->mediumInteger('created_by')->nullable()->unsigned();
            $table->mediumInteger('updated_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id', 'leave_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
