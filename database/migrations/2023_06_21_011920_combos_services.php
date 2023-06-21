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
        Schema::create('combos_services', function (Blueprint $table) {
            $table->unsignedInteger('combo_id');
            $table->unsignedInteger('service_id');
    
            $table->foreign('combo_id')->references('combo_id')->on('combos');
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
