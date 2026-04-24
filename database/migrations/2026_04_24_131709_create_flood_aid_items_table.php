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
        Schema::create('flood_aid_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flood_aid_id')->constrained('flood_aids');
            $table->string('name', 255);
            $table->integer('price', false, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flood_aid_items');
    }
};
