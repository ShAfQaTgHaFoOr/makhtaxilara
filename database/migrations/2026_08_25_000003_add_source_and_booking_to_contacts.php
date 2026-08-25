<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Where the query came from: contact | quote | callback | ...
            $table->string('source')->default('contact')->after('is_read');
            // Set once a query has been converted into a booking.
            $table->foreignId('booking_id')->nullable()->after('source')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('booking_id');
            $table->dropColumn('source');
        });
    }
};
