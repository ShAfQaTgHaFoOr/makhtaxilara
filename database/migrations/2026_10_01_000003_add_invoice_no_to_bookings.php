<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Invoice numbers start here; the first booking becomes 100000. */
    private const START = 100000;

    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('invoice_no')->nullable()->unique()->after('booking_no');
        });

        // Backfill existing bookings with sequential numbers, oldest first.
        $next = self::START;
        foreach (DB::table('bookings')->orderBy('id')->pluck('id') as $id) {
            DB::table('bookings')->where('id', $id)->update(['invoice_no' => $next++]);
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('invoice_no');
        });
    }
};
