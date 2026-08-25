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
            $table->string('booking_no')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();

            // customer
            $table->string('name');
            $table->string('email');
            $table->string('phone');

            // trip
            $table->string('trip_type')->default('distance'); // distance | hourly | fixed
            $table->string('pickup_location');
            $table->string('dropoff_location')->nullable();
            $table->dateTime('pickup_at');
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->unsignedSmallInteger('hours')->nullable();
            $table->unsignedSmallInteger('passengers')->default(1);
            $table->text('notes')->nullable();

            // money / status
            $table->decimal('fare_amount', 10, 2)->default(0);
            $table->string('status')->default('pending');          // pending|confirmed|completed|cancelled
            $table->string('payment_status')->default('unpaid');   // unpaid|paid|refunded
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();

            $table->timestamps();
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
