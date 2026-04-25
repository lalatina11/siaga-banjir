<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flood_aids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flood_id')->constrained('floods')->cascadeOnDelete();
            $table->enum('status', ['ON_DELIEVERY', 'ARRIVED'])->default('ON_DELIEVERY');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flood_aids');
    }
};
