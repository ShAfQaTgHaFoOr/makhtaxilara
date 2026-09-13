<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('landline')->nullable()->after('phone');
            $table->string('flight_number')->nullable()->after('pickup_location');
            $table->string('departure_time')->nullable()->after('dropoff_location');
            $table->string('makkah_hotel')->nullable()->after('passengers');
            $table->string('madina_hotel')->nullable()->after('makkah_hotel');
            $table->string('jeddah_hotel')->nullable()->after('madina_hotel');
            $table->string('taif_hotel')->nullable()->after('jeddah_hotel');
            $table->string('confirmed_by')->nullable()->after('notes');
            $table->string('agency')->nullable()->after('confirmed_by');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'landline', 'flight_number', 'departure_time',
                'makkah_hotel', 'madina_hotel', 'jeddah_hotel', 'taif_hotel',
                'confirmed_by', 'agency',
            ]);
        });
    }
};
