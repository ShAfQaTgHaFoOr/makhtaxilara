@extends('layouts.wp')
@section('title', $post->title . ' — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container">
            <h1>{{ $post->title }}</h1>
            <div class="mkt-crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('blog') }}">Blog</a></div>
        </div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container">
            <article class="mkt-article mkt-detail__content">
                <div class="mkt-post-meta">{{ optional($post->published_at)->format('d M Y') }}</div>
                {!! $post->content !!}
            </article>
        </div>
    </section>
</div>
@endsection
