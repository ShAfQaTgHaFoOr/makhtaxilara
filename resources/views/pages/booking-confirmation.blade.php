@extends('layouts.wp')
@section('title', 'Booking Confirmed — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-section mkt-section--grey">
        <div class="mkt-container">
            <div class="mkt-confirm">
                <div class="mkt-panel">
                    @if (session('status'))
                        <div class="mkt-alert mkt-alert--success">{{ session('status') }}</div>
                    @endif
                    <div class="mkt-confirm__check">✓</div>
                    <h2 style="margin:0">Booking confirmed!</h2>
                    <p class="mkt-help">Your reference number is <b>{{ $booking->booking_no }}</b>. We have received your request and will contact you shortly.</p>

                    <div class="mkt-summary">
                        <div class="mkt-fare__row"><span>Vehicle</span><b>{{ $booking->vehicle?->name ?? '—' }}</b></div>
                        <div class="mkt-fare__row"><span>Pickup</span><b>{{ $booking->pickup_location }}</b></div>
                        @if ($booking->dropoff_location)
                            <div class="mkt-fare__row"><span>Drop-off</span><b>{{ $booking->dropoff_location }}</b></div>
                        @endif
                        <div class="mkt-fare__row"><span>Pickup time</span><b>{{ $booking->pickup_at->format('D, d M Y H:i') }}</b></div>
                        <div class="mkt-fare__row"><span>Passengers</span><b>{{ $booking->passengers }}</b></div>
                        <div class="mkt-fare__row"><span>Estimated fare</span><b>${{ number_format($booking->fare_amount, 2) }}</b></div>
                        <div class="mkt-fare__row"><span>Status</span><b>{{ ucfirst($booking->status) }}</b></div>
                    </div>

                    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:24px">
                        @if ($booking->payment_status !== 'paid')
                            <a href="{{ route('payment.checkout', $booking->booking_no) }}" class="mkt-btn mkt-btn--primary mkt-btn--lg">Pay now (${{ number_format($booking->fare_amount, 2) }})</a>
                        @else
                            <span class="mkt-btn mkt-btn--ghost mkt-btn--lg">Paid ✓</span>
                        @endif
                        <a href="{{ route('home') }}" class="mkt-btn mkt-btn--dark mkt-btn--lg">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
