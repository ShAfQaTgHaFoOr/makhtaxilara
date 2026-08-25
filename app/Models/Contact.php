<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /** The booking this query was converted into, if any. */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function isConverted(): bool
    {
        return $this->booking_id !== null;
    }
}
