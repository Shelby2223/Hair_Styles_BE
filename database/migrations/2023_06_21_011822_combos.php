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
        Schema::create('combos', function (Blueprint $table) {
            $table->increments('combo_id');
            $table->string('combo_name');
            $table->text('combo_description');
            $table->decimal('combo_price', 8, 2);
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
