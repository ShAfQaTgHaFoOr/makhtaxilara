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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->longText('description')->nullable();   // HTML migrated from WP
            $table->string('image')->nullable();           // featured image url/path
            $table->json('gallery')->nullable();
            $table->unsignedSmallInteger('passengers')->default(4);
            $table->unsignedSmallInteger('luggage')->default(2);
            $table->decimal('base_fare', 10, 2)->default(0);
            $table->decimal('per_km', 10, 2)->default(0);
            $table->decimal('per_hour', 10, 2)->default(0);
            $table->decimal('min_fare', 10, 2)->default(0);
            $table->json('features')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('wp_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
