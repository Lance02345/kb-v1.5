@if ($paginator->hasPages())
    <div class="flex flex-col items-center gap-2 w-full">
        <span class="text-xs text-gray-400">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
            &nbsp;&middot;&nbsp;
            {{ $paginator->total() }} {{ Str::plural('result', $paginator->total()) }}
        </span>
        <div class="flex w-full flex-col gap-2 md:hidden">
            <div class="flex w-full items-center justify-between gap-2">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex min-w-[88px] items-center justify-center rounded-md border border-gray-800 bg-[#161a22] px-3 py-2 text-sm text-gray-500 opacity-40">Previous</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex min-w-[88px] items-center justify-center rounded-md border border-gray-800 bg-[#161a22] px-3 py-2 text-sm text-gray-200 hover:bg-gray-800 transition-colors">Previous</a>
                @endif

                <span class="inline-flex min-w-[96px] items-center justify-center rounded-md border border-amber-500/30 bg-amber-500/10 px-3 py-2 text-sm font-semibold text-amber-300">
                    {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </span>

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex min-w-[88px] items-center justify-center rounded-md border border-gray-800 bg-[#161a22] px-3 py-2 text-sm text-gray-200 hover:bg-gray-800 transition-colors">Next</a>
                @else
                    <span class="inline-flex min-w-[88px] items-center justify-center rounded-md border border-gray-800 bg-[#161a22] px-3 py-2 text-sm text-gray-500 opacity-40">Next</span>
                @endif
            </div>
            <div class="flex w-full gap-2 overflow-x-auto pb-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex h-9 min-w-[36px] items-center justify-center rounded-md px-2 text-sm text-gray-500">{{ $element }}</span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $p => $url)
                            @if ($p == $paginator->currentPage())
                                <span class="inline-flex h-9 min-w-[36px] items-center justify-center rounded-md bg-amber-500 px-3 text-sm font-medium text-black">{{ $p }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex h-9 min-w-[36px] items-center justify-center rounded-md border border-gray-800 bg-[#161a22] px-3 text-sm font-medium text-gray-300 hover:bg-gray-800 transition-colors">{{ $p }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
        <div class="hidden items-center gap-1 md:flex">
            @if ($paginator->onFirstPage())
                <span class="p-2 rounded-md bg-[#161a22] border border-gray-800 opacity-40 cursor-not-allowed">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="p-2 rounded-md bg-[#161a22] border border-gray-800 hover:bg-gray-800 transition-colors">‹</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-9 h-9 flex items-center justify-center rounded-md text-sm text-gray-500">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $p => $url)
                        @if ($p == $paginator->currentPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-md text-sm font-medium bg-amber-500 text-black">{{ $p }}</span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-md text-sm font-medium bg-[#161a22] border border-gray-800 text-gray-400 hover:bg-gray-800 transition-colors">{{ $p }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="p-2 rounded-md bg-[#161a22] border border-gray-800 hover:bg-gray-800 transition-colors">›</a>
            @else
                <span class="p-2 rounded-md bg-[#161a22] border border-gray-800 opacity-40 cursor-not-allowed">›</span>
            @endif
        </div>
    </div>
@endif
