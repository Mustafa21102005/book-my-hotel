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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_session_id')->nullable()->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('check_in');
            $table->date('check_out');
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->enum('payment_status', ['paid', 'refunded'])->default('paid');
            $table->enum('booking_status', ['active', 'cancelled', 'completed'])->default('active');
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['user_id', 'room_id', 'booking_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
