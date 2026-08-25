<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery'    => 'array',
        'features'   => 'array',
        'is_active'  => 'boolean',
        'base_fare'  => 'decimal:2',
        'per_km'     => 'decimal:2',
        'per_hour'   => 'decimal:2',
        'min_fare'   => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Estimate the fare for this vehicle given a trip.
     */
    public function estimateFare(string $tripType, ?float $distanceKm = null, ?int $hours = null): float
    {
        $fare = (float) $this->base_fare;

        if ($tripType === 'distance' && $distanceKm) {
            $fare += $distanceKm * (float) $this->per_km;
        } elseif ($tripType === 'hourly' && $hours) {
            $fare += $hours * (float) $this->per_hour;
        }

        return round(max($fare, (float) $this->min_fare), 2);
    }
}
