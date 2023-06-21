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
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('history_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('combo_id')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('shop_id')->references('shop_id')->on('shops');
            $table->foreign('service_id')->references('service_id')->on('services');
            $table->foreign('combo_id')->references('combo_id')->on('combos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
