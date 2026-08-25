@extends('layouts.wp')
@section('title', 'Blog — Makhah Taxi')

@section('content')
<div class="mkt-wrap">
    <section class="mkt-hero">
        <div class="mkt-container"><h1>From the Blog</h1><p>Travel tips, routes and company news.</p></div>
    </section>

    <section class="mkt-section">
        <div class="mkt-container">
            <div class="mkt-grid mkt-grid--3">
                @foreach ($posts as $post)
                    <div class="mkt-card">
                        @if ($post->image)
                            <a href="{{ route('post.show', $post) }}" class="mkt-card__media" style="background-image:url('{{ $post->image }}')"></a>
                        @endif
                        <div class="mkt-card__body mkt-post-card__body">
                            <div class="mkt-post-meta">{{ optional($post->published_at)->format('d M Y') }}</div>
                            <h3><a href="{{ route('post.show', $post) }}" style="color:inherit;text-decoration:none">{{ $post->title }}</a></h3>
                            <p class="mkt-card__excerpt">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
                            <a href="{{ route('post.show', $post) }}" class="mkt-btn mkt-btn--ghost">Read more</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mkt-pagination">{{ $posts->links('pagination.simple') }}</div>
        </div>
    </section>
</div>
@endsection
