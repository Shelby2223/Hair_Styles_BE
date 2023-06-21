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
        Schema::create('stylists', function (Blueprint $table) {
            $table->increments('stylist_id');
            $table->string('stylist_name');
            $table->string('stylist_image')->nullable();
            $table->float('stylist_rating')->nullable();
            $table->unsignedInteger('shop_id');
            $table->timestamps();
    
            $table->foreign('shop_id')->references('shop_id')->on('shops');
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
