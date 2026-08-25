@extends('layouts.wp')
@section('title', 'Our Fleet — Makhah Taxi')

@push('styles')
<style>
    .fleet-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    @media (max-width: 1100px) { .fleet-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 700px)  { .fleet-grid { grid-template-columns: 1fr; } }

    .fleet-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform .3s cubic-bezier(.25,.8,.25,1), box-shadow .3s, border-color .3s;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .fleet-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border-color: #FFD700;
    }
    .fleet-card::after {
        content: '';
        position: absolute; top: 0; left: 0;
        width: 100%; height: 6px;
        background: linear-gradient(90deg, #FFD700, #FFC107);
        opacity: .8;
    }

    .fleet-img {
        position: relative;
        background: #f9f9f9;
        padding: 15px;
        height: 190px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .fleet-img img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
    }
    .fleet-badge {
        position: absolute; top: 10px; right: 10px;
        background: rgba(255, 215, 0, 0.95);
        color: #333;
        font-size: 12px; font-weight: 700;
        padding: 4px 12px;
        border-radius: 15px;
        text-transform: uppercase;
    }

    .fleet-body { padding: 16px 20px 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .fleet-title { font-size: 19px; font-weight: 800; color: #2c3e50; text-align: center; margin-bottom: 4px; }
    .fleet-sub { font-size: 12px; color: #999; text-align: center; font-weight: 500; margin-bottom: 16px; min-height: 16px; }

    .fleet-specs { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 18px; }
    .fleet-spec {
        display: flex; align-items: center;
        background: #fdfdfd; padding: 8px 10px;
        border-radius: 8px; border: 1px solid #f5f5f5;
        font-size: 12px; font-weight: 600; color: #444;
        min-height: 40px; line-height: 1.2;
    }
    .fleet-spec .ic { margin-right: 6px; flex-shrink: 0; }

    .fleet-price { text-align: center; font-weight: 800; color: #2c3e50; margin-bottom: 14px; font-size: 15px; }
    .fleet-price small { color: #999; font-weight: 600; }

    .fleet-actions { margin-top: auto; display: flex; gap: 10px; }
    .fleet-actions a {
        flex: 1; text-align: center; padding: 11px;
        border-radius: 10px; text-decoration: none;
        font-weight: 700; font-size: 13px; transition: all .2s ease;
    }
    .fleet-details { background: #f4f4f4; color: #333; }
    .fleet-details:hover { background: #e9e9e9; }
    .fleet-book { background: #333; color: #FFD700 !important; }
    .fleet-book:hover { background: #FFD700; color: #333 !important; box-shadow: 0 5px 15px rgba(255,215,0,.4); }

    .fleet-empty { grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #777; }
</style>
@endpush

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>Our Fleet</h1>
            <p>Choose from our range of premium, well-maintained vehicles.</p>
            <div class="mkt-crumbs"><a href="{{ route('home') }}">Home</a> / Our Taxis</div>
        </div>
    </section>

    <section class="mkt-section">
        <div class="fleet-grid">
            @forelse ($vehicles as $vehicle)
                <div class="fleet-card">
                    <div class="fleet-img">
                        @if ($vehicle->per_km > 0)
                            <span class="fleet-badge">${{ number_format($vehicle->per_km, 2) }}/km</span>
                        @elseif ($vehicle->base_fare > 0)
                            <span class="fleet-badge">From ${{ number_format($vehicle->base_fare, 0) }}</span>
                        @endif
                        <img src="{{ $vehicle->image ?: '/wp-uploads/2025/11/car-6.png' }}" alt="{{ $vehicle->name }}">
                    </div>
                    <div class="fleet-body">
                        <div class="fleet-title">{{ $vehicle->name }}</div>
                        <div class="fleet-sub">{{ $vehicle->excerpt ?: 'Premium ride' }}</div>

                        <div class="fleet-specs">
                            <div class="fleet-spec"><span class="ic">👤</span><span>{{ $vehicle->passengers }} Seats</span></div>
                            <div class="fleet-spec"><span class="ic">🧳</span><span>{{ $vehicle->luggage }} Bags</span></div>
                            @foreach (array_slice($vehicle->features ?? [], 0, 2) as $feature)
                                <div class="fleet-spec"><span class="ic">✓</span><span>{{ $feature }}</span></div>
                            @endforeach
                        </div>

                        <div class="fleet-price">
                            Base fare <b>${{ number_format($vehicle->base_fare, 2) }}</b>
                            @if ($vehicle->per_km > 0)
                                <small>· ${{ number_format($vehicle->per_km, 2) }}/km</small>
                            @endif
                        </div>

                        <div class="fleet-actions">
                            <a class="fleet-details" href="{{ route('vehicle.show', $vehicle) }}">View Details</a>
                            <a class="fleet-book" href="{{ route('booking.create', ['vehicle' => $vehicle->id]) }}">Book Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="fleet-empty">No vehicles available at the moment. Please check back soon.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
