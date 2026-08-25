@extends('layouts.wp')
@section('title', 'My Bookings — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>My Bookings</h1>
            <p>Welcome back, {{ auth()->user()->name }}.</p>
        </div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container">
            @if (session('status'))
                <div class="mkt-alert mkt-alert--success">{{ session('status') }}</div>
            @endif

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:12px;flex-wrap:wrap">
                <a href="{{ route('booking.create') }}" class="mkt-btn mkt-btn--primary">+ New booking</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="mkt-btn mkt-btn--ghost">Logout</button>
                </form>
            </div>

            @forelse ($bookings as $b)
                <div class="mkt-panel" style="margin-bottom:16px">
                    <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px">
                        <div>
                            <b>{{ $b->booking_no }}</b> — {{ $b->vehicle?->name ?? 'Vehicle' }}<br>
                            <span class="mkt-help">{{ $b->pickup_location }} → {{ $b->dropoff_location ?: '—' }} · {{ $b->pickup_at->format('d M Y H:i') }}</span>
                        </div>
                        <div style="text-align:right">
                            <div class="mkt-price">${{ number_format($b->fare_amount, 2) }}</div>
                            <span class="mkt-help">{{ ucfirst($b->status) }} · {{ ucfirst($b->payment_status) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="mkt-panel">You have no bookings yet. <a href="{{ route('booking.create') }}">Book a ride</a>.</div>
            @endforelse

            <div class="mkt-pagination">{{ $bookings->links('pagination.simple') }}</div>
        </div>
    </section>
</div>
@endsection
