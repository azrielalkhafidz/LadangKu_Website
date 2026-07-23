<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watering_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->float('volume_liters')->nullable();
            $table->enum('status', ['success', 'interrupted', 'running'])->default('running');
            $table->enum('trigger', ['auto', 'manual'])->default('auto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watering_histories');
    }
};