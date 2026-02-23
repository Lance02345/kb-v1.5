@if ($paginator->hasPages())
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
@endif
