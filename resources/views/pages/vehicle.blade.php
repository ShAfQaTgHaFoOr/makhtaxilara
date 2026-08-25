@extends('layouts.wp')
@section('title', $vehicle->name . ' — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>{{ $vehicle->name }}</h1>
            <div class="mkt-crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('fleet') }}">Our Taxis</a> / {{ $vehicle->name }}</div>
        </div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container">
            <div class="mkt-detail">
                <div>
                    @if ($vehicle->image)
                        <img class="mkt-detail__img" src="{{ $vehicle->image }}" alt="{{ $vehicle->name }}">
                    @endif
                    <div class="mkt-detail__content" style="margin-top:26px">
                        {!! $vehicle->description !!}
                    </div>
                </div>
                <aside>
                    <div class="mkt-panel">
                        <h3 style="margin-top:0">Vehicle details</h3>
                        <ul class="mkt-specs" style="flex-direction:column;gap:10px">
                            <li>👤 Passengers: <b>{{ $vehicle->passengers }}</b></li>
                            <li>🧳 Luggage: <b>{{ $vehicle->luggage }}</b> bags</li>
                            <li>📍 Per km: <b>${{ number_format($vehicle->per_km, 2) }}</b></li>
                            <li>⏱️ Per hour: <b>${{ number_format($vehicle->per_hour, 2) }}</b></li>
                            <li>💰 Base fare: <b>${{ number_format($vehicle->base_fare, 2) }}</b></li>
                        </ul>
                        <a href="{{ route('booking.create', ['vehicle' => $vehicle->id]) }}" class="mkt-btn mkt-btn--primary mkt-btn--block mkt-btn--lg" style="margin-top:14px">Book this vehicle</a>
                    </div>
                </aside>
            </div>

            @if ($others->isNotEmpty())
                <h2 style="margin-top:56px">Other vehicles</h2>
                <div class="mkt-grid mkt-grid--3" style="margin-top:20px">
                    @foreach ($others as $o)
                        <div class="mkt-card">
                            <a href="{{ route('vehicle.show', $o) }}" class="mkt-card__media" style="background-image:url('{{ $o->image }}')"></a>
                            <div class="mkt-card__body">
                                <h3>{{ $o->name }}</h3>
                                <a href="{{ route('vehicle.show', $o) }}" class="mkt-btn mkt-btn--ghost">View details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
