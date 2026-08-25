@extends('layouts.wp')
@section('title', 'Create Account — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-section mkt-section--grey">
        <div class="mkt-container" style="max-width:520px">
            <div class="mkt-panel">
                <h2 style="margin-top:0">Create your account</h2>
                @if ($errors->any())
                    <div class="mkt-alert mkt-alert--error">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mkt-field">
                        <label>Full name</label>
                        <input class="mkt-input" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <div class="mkt-row">
                        <div class="mkt-field">
                            <label>Email</label>
                            <input class="mkt-input" type="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mkt-field">
                            <label>Phone</label>
                            <input class="mkt-input" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="mkt-row">
                        <div class="mkt-field">
                            <label>Password</label>
                            <input class="mkt-input" type="password" name="password" required>
                        </div>
                        <div class="mkt-field">
                            <label>Confirm password</label>
                            <input class="mkt-input" type="password" name="password_confirmation" required>
                        </div>
                    </div>
                    <button class="mkt-btn mkt-btn--primary mkt-btn--block mkt-btn--lg">Create account</button>
                </form>
                <p class="mkt-help" style="margin-top:16px">Already registered? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>
    </section>
</div>
@endsection
