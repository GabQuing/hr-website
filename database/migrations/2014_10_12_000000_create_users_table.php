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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile_number')->unique();
            $table->string('email')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('img')->nullable();
            $table->string('approval_status')->nullable();
            $table->integer('schedule_types_id')->length(10)->default(1)->unsigned()->nullable();
            $table->integer('work_hours_id')->length(10)->unsigned()->nullable();
            $table->integer('biometric_register')->default(0)->nullable();
            $table->string('approval_status')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
