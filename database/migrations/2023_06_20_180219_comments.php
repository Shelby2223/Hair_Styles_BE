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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('shop_id');
            $table->text('content');

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('shop_id')->references('shop_id')->on('shops');

            // Add other columns if needed

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
