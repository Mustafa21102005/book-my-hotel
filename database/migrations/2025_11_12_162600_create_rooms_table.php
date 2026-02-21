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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->enum('type', ['standard', 'deluxe', 'suite']);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->unsignedInteger('capacity')->default(1);
            $table->timestamps();

            // Indexes for faster filtering
            $table->index(['hotel_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
