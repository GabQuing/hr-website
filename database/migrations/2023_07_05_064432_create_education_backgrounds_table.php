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
        Schema::create('education_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('education_type_id')->length(10)->unsigned()->nullable();
            $table->string('school')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('degree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_backgrounds');
    }
};
