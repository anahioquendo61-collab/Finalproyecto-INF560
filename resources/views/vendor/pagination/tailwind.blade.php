@if ($paginator->hasPages())
    <nav class="flex items-center justify-between">
        <div class="text-xs text-slate-500">
            Mostrando {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
            de {{ $paginator->total() }} resultados
        </div>

        <div class="flex gap-1">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-xs text-slate-400 bg-rose-50 border border-rose-100 rounded-xl cursor-not-allowed">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-1.5 text-xs text-rose-600 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-100 transition-all">
                    ← Anterior
                </a>
            @endif

            {{-- Páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1.5 text-xs text-slate-400">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 text-xs text-white bg-rose-500 border border-rose-500 rounded-xl">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-1.5 text-xs text-rose-600 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-100 transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-1.5 text-xs text-rose-600 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-100 transition-all">
                    Siguiente →
                </a>
            @else
                <span class="px-3 py-1.5 text-xs text-slate-400 bg-rose-50 border border-rose-100 rounded-xl cursor-not-allowed">
                    Siguiente →
                </span>
            @endif
        </div>
    </nav>
@endif