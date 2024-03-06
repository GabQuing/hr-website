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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('schedule_types_id')->unsigned()->nullable();
            $table->date('shift_date')->nullable();
            $table->string('day_name')->storedAs('DAYNAME(shift_date)');
            $table->time('shift_from')->nullable();
            $table->time('shift_to')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('status')->nullable();
            $table->string('ot_classification')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->mediumInteger('created_by')->nullable()->unsigned();
            $table->mediumInteger('updated_by')->nullable()->unsigned();
            $table->mediumInteger('approved_by')->nullable()->unsigned();
            $table->mediumInteger('rejected_by')->nullable()->unsigned();
            $table->mediumInteger('cancelled_by')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
