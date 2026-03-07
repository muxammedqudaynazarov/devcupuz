@if ($paginator->hasPages())
    <nav class="custom-pagination">
        @if ($paginator->onFirstPage())
            <span class="page-link disabled">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link nav-btn">&laquo;</a>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-link dots">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link nav-btn">&raquo;</a>
        @else
            <span class="page-link disabled">&raquo;</span>
        @endif
    </nav>
@endif
