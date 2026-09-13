<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'joined_at' => 'date',
    ];

    /** The car assigned to this driver. */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /** Bookings assigned to this driver. */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /** Digits-only phone suitable for a wa.me / WhatsApp deep link. */
    public function whatsappNumber(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->phone);

        return $digits !== '' ? $digits : null;
    }
}
