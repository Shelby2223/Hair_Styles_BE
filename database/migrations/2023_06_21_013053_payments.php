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
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->unsignedInteger('history_id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('user_id');
            $table->decimal('payment_amount', 8, 2);
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('history_id')->references('history_id')->on('histories');
            $table->foreign('shop_id')->references('shop_id')->on('shops');
            $table->foreign('user_id')->references('user_id')->on('users');
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
