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
        'route_items'  => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_no)) {
                $booking->booking_no = 'MKT-' . strtoupper(Str::random(8));
            }
        });

        // When multiple route legs are entered, the fare is their sum (qty × amount).
        static::saving(function (Booking $booking) {
            if (! empty($booking->route_items)) {
                $booking->fare_amount = collect($booking->route_items)->sum(
                    fn ($it) => ((int) ($it['qty'] ?? 1) ?: 1) * (float) ($it['amount'] ?? 0)
                );
            }
        });
    }

    /** Country list for the nationality dropdown (value === label). */
    public static function nationalities(): array
    {
        $list = [
            'Afghanistan', 'Albania', 'Algeria', 'Argentina', 'Australia', 'Austria', 'Azerbaijan',
            'Bahrain', 'Bangladesh', 'Belgium', 'Bosnia and Herzegovina', 'Brazil', 'Brunei', 'Bulgaria',
            'Burkina Faso', 'Cameroon', 'Canada', 'Chad', 'China', 'Comoros', 'Denmark', 'Djibouti',
            'Egypt', 'Ethiopia', 'Finland', 'France', 'Gambia', 'Germany', 'Ghana', 'Greece', 'Guinea',
            'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Italy', 'Ivory Coast', 'Japan', 'Jordan',
            'Kazakhstan', 'Kenya', 'Kuwait', 'Kyrgyzstan', 'Lebanon', 'Libya', 'Malaysia', 'Maldives',
            'Mali', 'Mauritania', 'Morocco', 'Mozambique', 'Netherlands', 'Niger', 'Nigeria', 'Norway',
            'Oman', 'Pakistan', 'Palestine', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Russia',
            'Saudi Arabia', 'Senegal', 'Sierra Leone', 'Singapore', 'Somalia', 'South Africa', 'Spain',
            'Sri Lanka', 'Sudan', 'Sweden', 'Switzerland', 'Syria', 'Tajikistan', 'Tanzania', 'Thailand',
            'Tunisia', 'Turkey', 'Turkmenistan', 'Uganda', 'Ukraine', 'United Arab Emirates',
            'United Kingdom', 'United States', 'Uzbekistan', 'Yemen', 'Other',
        ];

        return array_combine($list, $list);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** The panel user (staff/admin) who created this booking. */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** [start, end] trip dates derived from the route legs, falling back to the booking date. */
    public function tripDateRange(): array
    {
        $dates = collect($this->route_items ?? [])
            ->pluck('date')->filter()->sort()->values();

        return [
            $dates->first() ?? $this->pickup_at?->format('Y-m-d'),
            $dates->last() ?? $this->pickup_at?->format('Y-m-d'),
        ];
    }

    /**
     * Route rows for the invoice — either the multi-leg items, or a single
     * synthesized row from pickup/dropoff. Each row: date, time, route, vehicle, qty, amount (line total).
     */
    public function routeRows(): array
    {
        if (! empty($this->route_items)) {
            return array_map(function ($it) {
                $qty = (int) ($it['qty'] ?? 1) ?: 1;

                return [
                    'date'    => $it['date'] ?? $this->pickup_at?->format('Y-m-d'),
                    'time'    => $it['time'] ?? $this->pickup_at?->format('H:i'),
                    'route'   => $it['route'] ?? '',
                    'vehicle' => $it['vehicle'] ?? ($this->vehicle?->name ?? ''),
                    'qty'     => $qty,
                    'amount'  => $qty * (float) ($it['amount'] ?? 0),
                ];
            }, $this->route_items);
        }

        return [[
            'date'    => $this->pickup_at?->format('Y-m-d'),
            'time'    => $this->pickup_at?->format('H:i'),
            'route'   => $this->pickup_location . ($this->dropoff_location ? ' → ' . $this->dropoff_location : ''),
            'vehicle' => $this->vehicle?->name ?? '—',
            'qty'     => 1,
            'amount'  => (float) $this->fare_amount,
        ]];
    }
}
