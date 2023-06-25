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
        Schema::create('user_register', function (Blueprint $table) {
            $table->increments('user_register_id');
            $table->string('user_register_name');
            $table->string('user_register_password');
            $table->string('user_register_phone');
            $table->string('user_register_email')->unique();
            $table->enum('user_register_type', ['B', 'C'])->default('C');
            // $table->boolean('is_admin')->default(false);
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
