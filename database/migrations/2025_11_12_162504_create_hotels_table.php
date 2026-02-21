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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->unique()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->enum('region', ['Asia', 'Europe']);
            $table->string('country');
            $table->string('city');
            $table->string('street');
            $table->boolean('breakfast')->default(false);
            $table->boolean('wifi')->default(true);
            $table->boolean('pool')->default(false);
            $table->boolean('gym')->default(false);
            $table->boolean('pets_allowed')->default(false);
            $table->boolean('environment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
