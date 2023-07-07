<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('stylist_id');
            $table->unsignedInteger('history_id');
            $table->unsignedInteger('combo_id');
            $table->unsignedInteger('service_id');

            // Add other columns if necessary

            // Add indexes if needed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
