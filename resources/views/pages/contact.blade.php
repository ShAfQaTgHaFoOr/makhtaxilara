@extends('layouts.wp')
@section('title', 'Contact Us — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>Contact Us</h1>
            <p>Questions or a custom trip? Send us a message.</p>
        </div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container">
            <div class="mkt-detail">
                <div class="mkt-panel">
                    @if (session('status'))
                        <div class="mkt-alert mkt-alert--success">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mkt-alert mkt-alert--error">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="mkt-row">
                            <div class="mkt-field">
                                <label>Name</label>
                                <input class="mkt-input" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mkt-field">
                                <label>Email</label>
                                <input class="mkt-input" type="email" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="mkt-row">
                            <div class="mkt-field">
                                <label>Phone</label>
                                <input class="mkt-input" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="mkt-field">
                                <label>Subject</label>
                                <input class="mkt-input" name="subject" value="{{ old('subject') }}">
                            </div>
                        </div>
                        <div class="mkt-field">
                            <label>Message</label>
                            <textarea class="mkt-textarea" name="message" required>{{ old('message') }}</textarea>
                        </div>
                        <button class="mkt-btn mkt-btn--primary mkt-btn--lg">Send message</button>
                    </form>
                </div>

                <aside>
                    <div class="mkt-panel">
                        <h3 style="margin-top:0">Get in touch</h3>
                        <p>📞 <b>{{ \App\Models\Setting::get('phone', '+966 000 000 000') }}</b></p>
                        <p>✉️ {{ \App\Models\Setting::get('email', 'info@makhahtaxi.com') }}</p>
                        <p>📍 {{ \App\Models\Setting::get('address', 'Makkah, Saudi Arabia') }}</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>
@endsection
