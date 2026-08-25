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
}
