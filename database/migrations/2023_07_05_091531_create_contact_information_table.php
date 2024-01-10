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
        Schema::create('contact_information', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('local_trunk_line')->nullable();
            $table->string('pin')->nullable();
            $table->string('home_address')->nullable();
            $table->string('home_city')->nullable();
            $table->string('state_province')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_information');
    }
};
