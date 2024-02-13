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
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('user_id')->nullable()->unsigned();
            $table->mediumInteger('log_type_id')->nullable()->unsigned();
            $table->timestamp('log_at')->nullable();
            $table->date('log_date')->storedAs('DATE(log_at)');
            $table->time('log_time')->storedAs('TIME(log_at)');
            $table->string('day_name')->storedAs('DAYNAME(log_at)');
            $table->string('status')->length(20)->nullable()->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();

            //index
            $table->index('user_id');
            $table->index('log_type_id');
            $table->index('log_at');
            $table->index('day_name');
            $table->index(['log_date']);
            $table->index(['log_type_id', 'log_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
};
