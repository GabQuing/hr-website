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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('schedule_types_id')->unsigned()->nullable();
            $table->string('leave_type')->nullable();
            $table->string('duration')->nullable();
            $table->date('leave_from')->nullable();
            $table->text('reason')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('leaves');
    }
};
