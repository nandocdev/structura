<div>
    @if ($paginator && $paginator->hasPages())
        <nav class="flex items-center justify-{{ $alignment }} gap-2">
            @if ($paginator->onFirstPage())
                <button disabled class="px-2 py-1 border border-zinc-300 rounded text-zinc-400 cursor-not-allowed">
                    {{ __('Previous') }}
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-2 py-1 border border-zinc-300 rounded hover:bg-zinc-100">
                    {{ __('Previous') }}
                </a>
            @endif

            <div class="flex gap-1">
                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-blue-500 text-white rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 border border-zinc-300 rounded hover:bg-zinc-100">{{ $page }}</a>
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-1 border border-zinc-300 rounded hover:bg-zinc-100">
                    {{ __('Next') }}
                </a>
            @else
                <button disabled class="px-2 py-1 border border-zinc-300 rounded text-zinc-400 cursor-not-allowed">
                    {{ __('Next') }}
                </button>
            @endif
        </nav>
    @endif
</div>
