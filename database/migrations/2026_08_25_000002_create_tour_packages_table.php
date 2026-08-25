<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // e.g. "Package 1", "Super Package 2"
            $table->string('badge')->nullable();       // e.g. "Hyundai Staria", "Via Train"
            $table->string('capacity')->nullable();    // e.g. "8 Seater 8 Luggage"
            $table->text('trips')->nullable();         // one trip leg per line
            $table->string('price')->nullable();       // numeric text, shown as "Total Cost SAR {price}"
            $table->string('image')->nullable();
            $table->string('footer_note')->nullable()->default('Full-car options for every trip');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
