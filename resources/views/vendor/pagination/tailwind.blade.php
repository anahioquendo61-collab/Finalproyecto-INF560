@if ($paginator->hasPages())
    <nav class="flex items-center justify-between">
        <div class="text-xs text-gray-500">
            Mostrando {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
            de {{ $paginator->total() }} resultados
        </div>
        <div class="flex gap-1">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-xs text-gray-600 bg-[#161B22] border border-white/5 rounded-lg cursor-not-allowed">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-1.5 text-xs text-gray-300 bg-[#161B22] border border-white/10 rounded-lg hover:bg-white/10 transition-all">
                    ← Anterior
                </a>
            @endif

            {{-- Páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1.5 text-xs text-gray-500">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 text-xs text-white bg-blue-600 border border-blue-500 rounded-lg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1.5 text-xs text-gray-300 bg-[#161B22] border border-white/10 rounded-lg hover:bg-white/10 transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-1.5 text-xs text-gray-300 bg-[#161B22] border border-white/10 rounded-lg hover:bg-white/10 transition-all">
                    Siguiente →
                </a>
            @else
                <span class="px-3 py-1.5 text-xs text-gray-600 bg-[#161B22] border border-white/5 rounded-lg cursor-not-allowed">
                    Siguiente →
                </span>
            @endif
        </div>
    </nav>
@endif