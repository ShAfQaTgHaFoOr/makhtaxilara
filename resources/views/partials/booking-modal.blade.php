{{-- Booking dialog opened from "BOOK NOW" on the home-page route/package cards. --}}
@php
    // Reopen with the user's input if a booking submitted from here failed validation.
    $bookingFromModal = old('_form') === 'booking';
@endphp
<div id="mkt-booking-modal" class="mkt-modal" role="dialog" aria-modal="true" aria-labelledby="mkt-booking-title">
    <div class="mkt-modal__backdrop" data-booking-close></div>
    <div class="mkt-modal__box" style="max-width:560px;">
        <button class="mkt-modal__x" type="button" data-booking-close aria-label="Close">&times;</button>
        <h2 id="mkt-booking-title" style="color:#16295c;font-size:24px;font-weight:700;margin:0 0 4px;text-transform:capitalize;">Book your ride</h2>
        <p style="color:#5b6b8c;margin:0 0 16px;font-size:14px;">Fill in your trip details and we'll confirm your booking.</p>

        <div id="mkt-booking-route-banner"
             style="background:#eef3ff;border:1px solid #c7d3ea;color:#16295c;font-weight:600;font-size:14px;padding:10px 12px;border-radius:8px;margin-bottom:16px;{{ $bookingFromModal && old('_route_label') ? '' : 'display:none;' }}">
            <span style="font-weight:700;">Package:</span> <span id="mkt-booking-route-name">{{ old('_route_label') }}</span>
        </div>

        <form method="POST" action="{{ route('booking.store') }}" id="mkt-booking-form">
            @csrf
            <input type="hidden" name="_form" value="booking">
            <input type="hidden" name="_route_label" id="mkt-booking-route-input" value="{{ old('_route_label') }}">
            <input type="hidden" name="trip_type" value="fixed">

            <div class="mkt-modal__field">
                <label class="mkt-modal__lbl">Vehicle *</label>
                <select name="vehicle_id" id="mkt-booking-vehicle" required class="mkt-modal__in">
                    @foreach ($vehicles as $v)
                        <option value="{{ $v->id }}"
                            data-base="{{ $v->base_fare }}" data-min="{{ $v->min_fare }}"
                            @selected((string) old('vehicle_id') === (string) $v->id)>
                            {{ $v->name }} ({{ $v->passengers }} seats)
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')<span class="mkt-modal__err">{{ $message }}</span>@enderror
            </div>

            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;">
                <div style="flex:1 1 220px;">
                    <label class="mkt-modal__lbl">Pickup location *</label>
                    <input name="pickup_location" id="mkt-booking-pickup" value="{{ old('pickup_location') }}" required
                           class="mkt-modal__in" placeholder="e.g. Makkah Hotel">
                    @error('pickup_location')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
                <div style="flex:1 1 220px;">
                    <label class="mkt-modal__lbl">Drop-off location</label>
                    <input name="dropoff_location" id="mkt-booking-dropoff" value="{{ old('dropoff_location') }}"
                           class="mkt-modal__in" placeholder="e.g. Madinah Hotel">
                    @error('dropoff_location')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;">
                <div style="flex:1 1 220px;">
                    <label class="mkt-modal__lbl">Pickup date &amp; time *</label>
                    <input type="datetime-local" name="pickup_at" value="{{ old('pickup_at') }}" required
                           min="{{ now()->format('Y-m-d\TH:i') }}" class="mkt-modal__in">
                    @error('pickup_at')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
                <div style="flex:1 1 120px;">
                    <label class="mkt-modal__lbl">Passengers *</label>
                    <input type="number" name="passengers" min="1" max="60" value="{{ old('passengers', 1) }}" required class="mkt-modal__in">
                    @error('passengers')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;">
                <div style="flex:1 1 220px;">
                    <label class="mkt-modal__lbl">Full name *</label>
                    <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required class="mkt-modal__in">
                    @error('name')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
                <div style="flex:1 1 220px;">
                    <label class="mkt-modal__lbl">Phone *</label>
                    <input name="phone" value="{{ old('phone') }}" required class="mkt-modal__in" inputmode="tel">
                    @error('phone')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="margin-top:12px;">
                <label class="mkt-modal__lbl">Email (optional)</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="mkt-modal__in">
                @error('email')<span class="mkt-modal__err">{{ $message }}</span>@enderror
            </div>

            <div style="margin-top:12px;">
                <label class="mkt-modal__lbl">Notes (optional)</label>
                <textarea name="notes" rows="2" class="mkt-modal__in" style="resize:vertical;">{{ old('notes') }}</textarea>
                @error('notes')<span class="mkt-modal__err">{{ $message }}</span>@enderror
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:16px;background:#f4f7fc;border-radius:8px;padding:10px 14px;">
                <span style="font-size:13px;color:#5b6b8c;">Estimated fare</span>
                <b id="mkt-booking-fare" style="font-size:20px;color:#16295c;">$0.00</b>
            </div>
            <p style="color:#8794ad;margin:8px 0 0;font-size:11px;">Final fare may vary with route, waiting time and tolls.</p>

            <button type="submit" class="mkt-modal__btn">Confirm booking</button>
        </form>
    </div>
</div>

<script>
    (function () {
        var modal = document.getElementById('mkt-booking-modal');
        if (!modal) return;
        var open = function () { modal.classList.add('is-open'); };
        var close = function () { modal.classList.remove('is-open'); };

        modal.querySelectorAll('[data-booking-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

        var routeBanner = document.getElementById('mkt-booking-route-banner');
        var routeName = document.getElementById('mkt-booking-route-name');
        var routeInput = document.getElementById('mkt-booking-route-input');
        var pickup = document.getElementById('mkt-booking-pickup');
        var dropoff = document.getElementById('mkt-booking-dropoff');

        // Split "A to B" / "A → B" / "A - B" into pickup + drop-off.
        var splitRoute = function (label) {
            if (!label) return null;
            var parts = label.split(/\s*(?:→|->|—|–|-|\bto\b)\s*/i).filter(Boolean);
            if (parts.length >= 2) return { from: parts[0].trim(), to: parts.slice(1).join(' ').trim() };
            return { from: label.trim(), to: '' };
        };

        // Wire every "BOOK NOW" button that carries a data-route.
        document.querySelectorAll('[data-booking-open]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var label = btn.getAttribute('data-route') || '';
                if (routeInput) routeInput.value = label;
                if (label) {
                    if (routeName) routeName.textContent = label;
                    if (routeBanner) routeBanner.style.display = '';
                    var rt = splitRoute(label);
                    if (rt && pickup && !pickup.value) pickup.value = rt.from;
                    if (rt && dropoff && !dropoff.value) dropoff.value = rt.to;
                } else if (routeBanner) {
                    routeBanner.style.display = 'none';
                }
                open();
            });
        });

        // Live fare estimate (base/min of the selected vehicle).
        var veh = document.getElementById('mkt-booking-vehicle');
        var fareEl = document.getElementById('mkt-booking-fare');
        var calc = function () {
            if (!veh || !fareEl) return;
            var o = veh.options[veh.selectedIndex];
            var base = parseFloat(o.dataset.base) || 0;
            var min = parseFloat(o.dataset.min) || 0;
            fareEl.textContent = '$' + Math.max(base, min).toFixed(2);
        };
        if (veh) { veh.addEventListener('change', calc); calc(); }

        // Reopen automatically if a booking from this modal failed validation.
        if (@json($bookingFromModal)) open();
    })();
</script>

<style>
    .mkt-modal__field { margin-top:0; }
</style>
