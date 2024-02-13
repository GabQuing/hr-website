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
        Schema::create('government_information', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('user_id')->unsigned()->nullable();
            $table->string('name')->length(255)->nullable();
            $table->text('address')->nullable();
            $table->string('bank_name')->length(255)->nullable();
            $table->text('bank_address')->nullable();
            $table->string('bank_account_number')->length(255)->nullable();
            $table->string('bank_swift_code')->length(255)->nullable();
            $table->string('bank_routing_number')->length(255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('government_information');
    }
};
