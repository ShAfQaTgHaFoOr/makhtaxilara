@if ($paginator->hasPages())
    @if (! $paginator->onFirstPage())
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Prev</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span>{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="mkt-active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
    @endif
@endif
