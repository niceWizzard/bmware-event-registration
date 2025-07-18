@if ($paginator->hasPages())
    <div class="flex flex-col items-center">
        <div class="text-sm text-gray-500 mb-2">
            Showing {{ $paginator->count() }} of {{ $paginator->total() }} items
        </div>
        <ul class="join">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="join-item btn btn-disabled">Prev</li>
            @else
                <li class="btn join-item"><a href="{{ $paginator->previousPageUrl() }}"> Prev</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="btn join-item">...</li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="join-item btn btn-active">{{ $page }}</li>
                        @else
                            <a href="{{ $url }}" class="join-item btn ">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn ">Next </a>
            @else
                <li class="btn join-item btn-disabled">Next</li>
            @endif
        </ul>
    </div>
@endif
