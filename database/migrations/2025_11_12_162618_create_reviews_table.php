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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('rating')->unsigned()->default(5); // 1–5 stars
            $table->string('title');
            $table->text('comment')->nullable();
            $table->timestamps();

            // Index for fast queries by hotel
            $table->index(['hotel_id', 'rating']);

            // Only one review per user per hotel
            $table->unique(['user_id', 'hotel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
