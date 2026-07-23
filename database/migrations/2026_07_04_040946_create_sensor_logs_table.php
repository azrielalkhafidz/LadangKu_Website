<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->float('soil_moisture')->nullable();
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();
            $table->boolean('pump_status')->default(false);
            $table->boolean('led_status')->default(false);
            $table->enum('pump_mode', ['auto', 'manual'])->default('auto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};