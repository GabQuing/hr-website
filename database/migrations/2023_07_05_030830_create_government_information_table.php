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
            $table->integer('user_id')->nullable();
            $table->string('sss')->nullable();
            $table->string('phil_health')->nullable();
            $table->string('tin')->nullable();
            $table->string('hdmf')->nullable();
            $table->string('pag_ibig')->nullable();
            $table->string('tax_status')->nullable();
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
