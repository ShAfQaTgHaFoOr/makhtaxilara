@extends('layouts.wp')
@section('title', 'Our Fleet — Makhah Taxi')

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
        <div class="mkt-container">
            <div class="mkt-grid mkt-grid--3">
                @foreach ($vehicles as $vehicle)
                    <div class="mkt-card">
                        <a href="{{ route('vehicle.show', $vehicle) }}"
                           class="mkt-card__media"
                           style="background-image:url('{{ $vehicle->image ?: '/wp-content/themes/vw-taxi-booking/images/logo.png' }}')"></a>
                        <div class="mkt-card__body">
                            <h3>{{ $vehicle->name }}</h3>
                            <p class="mkt-card__excerpt">{{ $vehicle->excerpt }}</p>
                            <ul class="mkt-specs">
                                <li>👤 <b>{{ $vehicle->passengers }}</b> seats</li>
                                <li>🧳 <b>{{ $vehicle->luggage }}</b> bags</li>
                            </ul>
                            <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
                                <span class="mkt-price">${{ number_format($vehicle->per_km, 2) }} <span>/ km</span></span>
                                <a href="{{ route('booking.create', ['vehicle' => $vehicle->id]) }}" class="mkt-btn mkt-btn--primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
