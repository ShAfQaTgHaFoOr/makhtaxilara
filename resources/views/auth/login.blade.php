@extends('layouts.wp')
@section('title', 'Login — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-section mkt-section--grey">
        <div class="mkt-container" style="max-width:480px">
            <div class="mkt-panel">
                <h2 style="margin-top:0">Login</h2>
                @if (session('status'))
                    <div class="mkt-alert mkt-alert--success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mkt-alert mkt-alert--error">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mkt-field">
                        <label>Email</label>
                        <input class="mkt-input" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mkt-field">
                        <label>Password</label>
                        <input class="mkt-input" type="password" name="password" required>
                    </div>
                    <label class="mkt-help"><input type="checkbox" name="remember"> Remember me</label>
                    <button class="mkt-btn mkt-btn--primary mkt-btn--block mkt-btn--lg" style="margin-top:14px">Login</button>
                </form>
                <p class="mkt-help" style="margin-top:16px">No account? <a href="{{ route('register') }}">Create one</a></p>
            </div>
        </div>
    </section>
</div>
@endsection
