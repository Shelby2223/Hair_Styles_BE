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
        Schema::create('Shop_Register', function (Blueprint $table) {
            $table->increments('Shop_Register_id');
            $table->string('Shop_Register_name');
            $table->string('Shop_Register_image')->nullable();
            $table->string('Shop_Register_address');
            $table->string('Shop_Register_phone');
            $table->unsignedInteger('user_id'); // Đổi kiểu dữ liệu thành unsignedInteger
            $table->timestamps();
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
