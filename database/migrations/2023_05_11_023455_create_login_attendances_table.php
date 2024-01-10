<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_name')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('store_address')->nullable();
            $table->string('log_type')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('uuid')->nullable();
            $table->integer('data_sync')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_attendances');
    }
}
