@extends('layouts.wp')
@section('title', 'Book a Ride — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>Book Your Ride</h1>
            <p>Instant fare estimate. Confirm in under a minute.</p>
        </div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container">
            @if ($errors->any())
                <div class="mkt-alert mkt-alert--error">
                    Please check the form: {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('booking.store') }}" id="mkt-booking-form">
                @csrf
                <div class="mkt-detail">
                    <div class="mkt-panel">
                        <h3 style="margin-top:0">Trip details</h3>

                        <div class="mkt-field">
                            <label>Vehicle</label>
                            <select name="vehicle_id" class="mkt-select" id="mkt-vehicle" required>
                                @foreach ($vehicles as $v)
                                    <option value="{{ $v->id }}"
                                        data-perkm="{{ $v->per_km }}" data-perhour="{{ $v->per_hour }}"
                                        data-base="{{ $v->base_fare }}" data-min="{{ $v->min_fare }}"
                                        @selected((string) old('vehicle_id', $selected) === (string) $v->id)>
                                        {{ $v->name }} ({{ $v->passengers }} seats)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mkt-field">
                            <label>Trip type</label>
                            <select name="trip_type" class="mkt-select" id="mkt-triptype">
                                <option value="distance" @selected(old('trip_type')==='distance')>By distance</option>
                                <option value="hourly" @selected(old('trip_type')==='hourly')>Hourly hire</option>
                                <option value="fixed" @selected(old('trip_type')==='fixed')>Fixed / airport transfer</option>
                            </select>
                        </div>

                        <div class="mkt-row">
                            <div class="mkt-field">
                                <label>Pickup location</label>
                                <input class="mkt-input" name="pickup_location" value="{{ old('pickup_location') }}" placeholder="e.g. Makkah Hotel" required>
                            </div>
                            <div class="mkt-field">
                                <label>Drop-off location</label>
                                <input class="mkt-input" name="dropoff_location" value="{{ old('dropoff_location') }}" placeholder="e.g. Jeddah Airport">
                            </div>
                        </div>

                        <div class="mkt-row">
                            <div class="mkt-field" id="mkt-distance-wrap">
                                <label>Distance (km)</label>
                                <input class="mkt-input" type="number" step="0.1" min="0" name="distance_km" id="mkt-distance" value="{{ old('distance_km') }}">
                            </div>
                            <div class="mkt-field" id="mkt-hours-wrap">
                                <label>Hours</label>
                                <input class="mkt-input" type="number" min="1" name="hours" id="mkt-hours" value="{{ old('hours') }}">
                            </div>
                        </div>

                        <div class="mkt-row">
                            <div class="mkt-field">
                                <label>Pickup date &amp; time</label>
                                <input class="mkt-input" type="datetime-local" name="pickup_at" value="{{ old('pickup_at') }}" required>
                            </div>
                            <div class="mkt-field">
                                <label>Passengers</label>
                                <input class="mkt-input" type="number" min="1" max="60" name="passengers" value="{{ old('passengers', 1) }}" required>
                            </div>
                        </div>

                        <h3>Your details</h3>
                        <div class="mkt-row">
                            <div class="mkt-field">
                                <label>Full name</label>
                                <input class="mkt-input" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="mkt-field">
                                <label>Phone</label>
                                <input class="mkt-input" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        <div class="mkt-field">
                            <label>Email</label>
                            <input class="mkt-input" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>
                        <div class="mkt-field">
                            <label>Notes (optional)</label>
                            <textarea class="mkt-textarea" name="notes">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <aside>
                        <div class="mkt-fare">
                            <h4>Estimated fare</h4>
                            <div class="mkt-fare__amount" id="mkt-fare-amount">$0.00</div>
                            <div class="mkt-fare__row"><span>Base fare</span><b id="mkt-fare-base">$0.00</b></div>
                            <div class="mkt-fare__row"><span>Trip charge</span><b id="mkt-fare-trip">$0.00</b></div>
                            <p class="mkt-help" style="color:#aab; margin-top:14px">Final fare may vary with route, waiting time and tolls.</p>
                            <button type="submit" class="mkt-btn mkt-btn--primary mkt-btn--block mkt-btn--lg" style="margin-top:8px">Confirm booking</button>
                        </div>
                    </aside>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const money = n => '$' + (Number(n) || 0).toFixed(2);
    const veh = document.getElementById('mkt-vehicle');
    const type = document.getElementById('mkt-triptype');
    const dist = document.getElementById('mkt-distance');
    const hours = document.getElementById('mkt-hours');
    const distWrap = document.getElementById('mkt-distance-wrap');
    const hoursWrap = document.getElementById('mkt-hours-wrap');

    function opt(){ return veh.options[veh.selectedIndex]; }

    function toggle(){
        const t = type.value;
        distWrap.style.display  = (t === 'distance') ? '' : 'none';
        hoursWrap.style.display = (t === 'hourly')   ? '' : 'none';
    }

    function calc(){
        const o = opt();
        const base = parseFloat(o.dataset.base) || 0;
        const perkm = parseFloat(o.dataset.perkm) || 0;
        const perhour = parseFloat(o.dataset.perhour) || 0;
        const min = parseFloat(o.dataset.min) || 0;
        let trip = 0;
        if (type.value === 'distance') trip = (parseFloat(dist.value) || 0) * perkm;
        else if (type.value === 'hourly') trip = (parseInt(hours.value) || 0) * perhour;
        let total = Math.max(base + trip, min);
        document.getElementById('mkt-fare-base').textContent = money(base);
        document.getElementById('mkt-fare-trip').textContent = money(trip);
        document.getElementById('mkt-fare-amount').textContent = money(total);
    }

    [veh, type, dist, hours].forEach(el => { el.addEventListener('input', () => { toggle(); calc(); }); });
    toggle(); calc();
});
</script>
@endpush
