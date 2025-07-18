@if ($paginator->hasPages())
    <div class="flex flex-col items-center">
        <div class="text-sm text-gray-500 mb-2">
            Showing {{ $paginator->count() }} of {{ $paginator->total() }} items
        </div>
        <ul class="join relative">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="join-item btn btn-disabled">Prev</li>
            @else
                <li class="btn join-item"><a href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="join-item relative" x-data="{
    open: false,
    pageNumber: null,
    position: 'bottom',
    toggle() {
        const rect = $el.getBoundingClientRect();
        this.position = (window.innerHeight - rect.bottom < 200) ? 'top' : 'bottom';
        this.open = !this.open;
    }
}">
                        <button class="btn" @click="toggle">
                            ...
                        </button>

                        <form
                            x-show="open"
                            @click.away="open = false"
                            @submit.prevent="if (pageNumber > 0) window.location.href = '{{ $paginator->url('__PAGE__') }}'.replace('__PAGE__', pageNumber)"
                            x-transition
                            class="absolute z-10 left-1/2 -translate-x-1/2 bg-white border border-gray-200 shadow-md rounded-md p-2 text-sm w-48"
                            :class="position === 'top' ? 'bottom-full mb-1' : 'top-full mt-1'"
                        >
                            <label class="block text-gray-700 text-sm mb-1">Go to page</label>
                            <input
                                type="number"
                                x-model.number="pageNumber"
                                min="1"
                                max="{{ $paginator->lastPage() }}"
                                class="w-full input"
                                placeholder="1-{{ $paginator->lastPage() }}"
                            />
                            <button type="submit" class="mt-2 btn btn-sm btn-primary w-full">Go</button>
                        </form>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="join-item btn btn-active">{{ $page }}</li>
                        @else
                            <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn">Next</a>
            @else
                <li class="btn join-item btn-disabled">Next</li>
            @endif
        </ul>
    </div>
@endif
