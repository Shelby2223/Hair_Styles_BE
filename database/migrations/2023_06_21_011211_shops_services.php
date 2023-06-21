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
        Schema::create('shops_services', function (Blueprint $table) {
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('service_id');
            $table->decimal('service_price', 8, 2);

            $table->foreign('shop_id')->references('shop_id')->on('shops');
            $table->foreign('service_id')->references('service_id')->on('services');
            $table->timestamps();
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
