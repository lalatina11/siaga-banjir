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
        Schema::create('floods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->text('description')->default("");
            $table->text('image');
            $table->text('image_storage_url')->nullable();
            $table->enum('status', [
                'PENDING',
                'NEW',
                'AID_DISPATCHED',
                'AID_ARRIVED',
                'RESOLVE'
            ])->default(value: 'PENDING');
            $table->text('province');
            $table->text('regency');
            $table->text('district');
            $table->text('village');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floods');
    }
};
