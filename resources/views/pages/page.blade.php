@extends('layouts.wp')
@section('title', $page->title . ' — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>{{ $page->title }}</h1>
            <div class="mkt-crumbs"><a href="{{ route('home') }}">Home</a> / {{ $page->title }}</div>
        </div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container mkt-detail__content">
            {!! $page->content !!}
        </div>
    </section>
</div>
@endsection
