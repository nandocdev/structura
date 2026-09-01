<div>
    @if (count($breadcrumbs) > 0)
        <nav class="flex items-center gap-1 text-sm">
            @foreach ($breadcrumbs as $index => $crumb)
                @if ($loop->index > 0)
                    <span class="text-zinc-400">{{ $separator }}</span>
                @endif

                @if (isset($crumb['href']) && !$crumb['active'])
                    <a href="{{ $crumb['href'] }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300" wire:navigate>
                        {{ $crumb['label'] }}
                    </a>
                @else
                    <span class="text-zinc-700 dark:text-zinc-300 font-medium">
                        {{ $crumb['label'] }}
                    </span>
                @endif
            @endforeach
        </nav>
    @endif
</div>
