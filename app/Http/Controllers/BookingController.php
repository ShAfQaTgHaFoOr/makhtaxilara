<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $vehicles = Vehicle::where('is_active', true)->orderBy('sort_order')->get();
        $selected = $request->query('vehicle');

        return view('pages.booking', compact('vehicles', 'selected'));
    }

    /** AJAX fare estimate. */
    public function estimate(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'trip_type'  => ['required', 'in:distance,hourly,fixed'],
            'distance_km'=> ['nullable', 'numeric', 'min:0'],
            'hours'      => ['nullable', 'integer', 'min:1'],
        ]);

        $vehicle = Vehicle::findOrFail($data['vehicle_id']);
        $fare = $vehicle->estimateFare(
            $data['trip_type'],
            $data['distance_km'] ?? null,
            $data['hours'] ?? null,
        );

        return response()->json([
            'fare'     => $fare,
            'currency' => strtoupper(config('cashier.currency', 'usd')),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'       => ['required', 'exists:vehicles,id'],
            'name'             => ['required', 'string', 'max:120'],
            'email'            => ['nullable', 'email', 'max:160'],
            'phone'            => ['required', 'string', 'max:40'],
            'trip_type'        => ['nullable', 'in:distance,hourly,fixed'],
            'pickup_location'  => ['required', 'string', 'max:200'],
            'dropoff_location' => ['nullable', 'string', 'max:200'],
            'pickup_at'        => ['required', 'date', 'after:now'],
            'distance_km'      => ['nullable', 'numeric', 'min:0'],
            'hours'            => ['nullable', 'integer', 'min:1'],
            'passengers'       => ['required', 'integer', 'min:1', 'max:60'],
            'notes'            => ['nullable', 'string', 'max:2000'],
        ]);

        $data['trip_type'] = $data['trip_type'] ?? 'fixed';
        $vehicle = Vehicle::findOrFail($data['vehicle_id']);
        $data['fare_amount'] = $vehicle->estimateFare(
            $data['trip_type'],
            $data['distance_km'] ?? null,
            $data['hours'] ?? null,
        );
        $data['user_id'] = $request->user()?->id;

        $booking = Booking::create($data);

        return redirect()->route('booking.confirmation', $booking->booking_no);
    }

    public function confirmation(string $booking_no)
    {
        $booking = Booking::with('vehicle')->where('booking_no', $booking_no)->firstOrFail();

        return view('pages.booking-confirmation', compact('booking'));
    }
}
