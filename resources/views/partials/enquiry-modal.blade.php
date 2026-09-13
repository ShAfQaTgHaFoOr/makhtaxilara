{{-- Site-wide auto-opening enquiry dialog --}}
@php
    $enquiryHasErrors = $errors->has('name') || $errors->has('phone') || $errors->has('email') || $errors->has('message');
    $enquiryDone = (bool) session('enquiry_status');
@endphp
<div id="mkt-enquiry-modal" class="mkt-modal" role="dialog" aria-modal="true" aria-labelledby="mkt-enquiry-title">
    <div class="mkt-modal__backdrop" data-enquiry-close></div>
    <div class="mkt-modal__box">
        <button class="mkt-modal__x" type="button" data-enquiry-close aria-label="Close">&times;</button>
        <h2 id="mkt-enquiry-title" style="color:#16295c;font-size:24px;font-weight:700;margin:0 0 4px;text-transform:capitalize;">Have a question?</h2>
        <p style="color:#5b6b8c;margin:0 0 18px;font-size:14px;">Leave your details and our team will get back to you shortly.</p>

        @if ($enquiryDone)
            <div style="background:#25d366;color:#fff;padding:11px 14px;border-radius:8px;margin-bottom:16px;text-align:center;font-weight:600;">
                {{ session('enquiry_status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('enquiry.submit') }}">
            @csrf
            <div style="display:flex;flex-wrap:wrap;gap:12px;">
                <div style="flex:1 1 180px;">
                    <label class="mkt-modal__lbl">Name *</label>
                    <input name="name" value="{{ old('name') }}" required class="mkt-modal__in">
                    @error('name')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
                <div style="flex:1 1 180px;">
                    <label class="mkt-modal__lbl">Phone *</label>
                    <input name="phone" value="{{ old('phone') }}" required class="mkt-modal__in">
                    @error('phone')<span class="mkt-modal__err">{{ $message }}</span>@enderror
                </div>
            </div>
            <div style="margin-top:12px;">
                <label class="mkt-modal__lbl">Email (optional)</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mkt-modal__in">
                @error('email')<span class="mkt-modal__err">{{ $message }}</span>@enderror
            </div>
            <div style="margin-top:12px;">
                <label class="mkt-modal__lbl">Message *</label>
                <textarea name="message" rows="3" required class="mkt-modal__in" style="resize:vertical;">{{ old('message') }}</textarea>
                @error('message')<span class="mkt-modal__err">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="mkt-modal__btn">Send enquiry</button>
        </form>
    </div>
</div>

<button id="mkt-enquiry-fab" type="button" aria-label="Open enquiry form">
    <span style="font-size:18px;">💬</span> Enquiry
</button>

<style>
    .mkt-modal { display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; padding:16px; }
    .mkt-modal.is-open { display:flex; }
    .mkt-modal__backdrop { position:absolute; inset:0; background:rgba(9,17,40,.6); backdrop-filter:blur(2px); }
    .mkt-modal__box { position:relative; z-index:1; width:100%; max-width:460px; background:#fff; border-radius:14px; padding:26px 24px; box-shadow:0 20px 60px rgba(0,0,0,.35); animation:mktPop .22s ease; max-height:92vh; overflow:auto; }
    @keyframes mktPop { from { opacity:0; transform:translateY(14px) scale(.98);} to { opacity:1; transform:none;} }
    .mkt-modal__x { position:absolute; top:10px; right:14px; border:0; background:none; font-size:28px; line-height:1; color:#8794ad; cursor:pointer; }
    .mkt-modal__x:hover { color:#16295c; }
    .mkt-modal__lbl { display:block; font-size:12px; font-weight:600; color:#16295c; margin-bottom:5px; }
    .mkt-modal__in { width:100%; padding:10px 12px; border:1px solid #c7d3ea; border-radius:8px; font-size:14px; font-family:inherit; }
    .mkt-modal__err { color:#d33; font-size:11px; }
    .mkt-modal__btn { margin-top:18px; width:100%; background:#16295c; color:#fff; border:0; padding:13px; border-radius:8px; font-size:15px; font-weight:700; cursor:pointer; text-transform:capitalize; }
    .mkt-modal__btn:hover { background:#1f3a7a; }
    #mkt-enquiry-fab { position:fixed; bottom:22px; right:22px; z-index:9998; background:#16295c; color:#fff; border:0; border-radius:40px; padding:12px 18px; font-size:14px; font-weight:700; cursor:pointer; box-shadow:0 8px 24px rgba(0,0,0,.28); display:flex; align-items:center; gap:7px; }
    #mkt-enquiry-fab:hover { background:#1f3a7a; }
</style>

<script>
    (function () {
        var modal = document.getElementById('mkt-enquiry-modal');
        var fab = document.getElementById('mkt-enquiry-fab');
        if (!modal) return;
        var open = function () { modal.classList.add('is-open'); };
        var close = function () { modal.classList.remove('is-open'); };

        modal.querySelectorAll('[data-enquiry-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
        if (fab) fab.addEventListener('click', open);

        var forceOpen = @json($enquiryHasErrors);
        var done = @json($enquiryDone);

        if (forceOpen) {
            open(); // re-show with validation errors
        } else if (done) {
            try { sessionStorage.setItem('mkt_enquiry_seen', '1'); } catch (e) {}
        } else {
            var seen = false;
            try { seen = sessionStorage.getItem('mkt_enquiry_seen') === '1'; } catch (e) {}
            if (!seen) {
                setTimeout(function () {
                    open();
                    try { sessionStorage.setItem('mkt_enquiry_seen', '1'); } catch (e) {}
                }, 1500);
            }
        }
    })();
</script>
