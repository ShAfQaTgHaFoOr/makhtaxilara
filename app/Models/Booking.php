<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'pickup_at'    => 'datetime',
        'distance_km'  => 'decimal:2',
        'fare_amount'  => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_no)) {
                $booking->booking_no = 'MKT-' . strtoupper(Str::random(8));
            }
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
