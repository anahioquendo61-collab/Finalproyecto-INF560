<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-rose-700 font-semibold text-lg">
                Tableros
            </h1>
            @can('crear proyecto')
                <a href="{{ route('projects.create') }}"
                   class="px-4 py-1.5 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                    + Nuevo tablero
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Filtros --}}
        <form method="GET" action="{{ route('projects.index') }}"
              class="flex gap-2 flex-wrap mb-6">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                   placeholder="Buscar tablero..."
                   class="bg-white border border-rose-100 text-slate-700 text-sm rounded-xl px-4 py-2 w-56
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all placeholder:text-slate-300" />
            <select name="estado"
                    class="bg-white border border-rose-100 text-slate-600 text-sm rounded-xl px-4 py-2
                    focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                <option value="">Todos los estados</option>
                @foreach (['activo', 'pausado', 'finalizado'] as $e)
                    <option value="{{ $e }}" @selected(request('estado') === $e)>
                        {{ ucfirst($e) }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm rounded-xl transition-all shadow-sm shadow-rose-500/20">
                Filtrar
            </button>
            <a href="{{ route('projects.index') }}"
               class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl border border-rose-100 transition-all">
                Limpiar
            </a>
        </form>

        {{-- Grid de tableros estilo Trello --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($projects as $project)
                <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden hover:border-rose-200 hover:shadow-md transition-all group">

                    {{-- Header del tablero con color --}}
                    <div class="h-20 relative flex items-end p-3"
                         style="background-color: {{ $project->color }}">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="relative z-10">
                            <span class="text-[11px] text-white/90 font-medium px-2 py-0.5 bg-black/30 rounded-full">
                                {{ ucfirst($project->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="text-slate-800 font-semibold text-sm mb-1 truncate">
                            {{ $project->nombre }}
                        </h3>
                        <p class="text-slate-500 text-xs mb-3 line-clamp-2">
                            {{ $project->descripcion ?? 'Sin descripción.' }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                            <span>{{ $project->tasks()->count() }} tareas</span>
                            <span>{{ $project->members()->count() }} miembros</span>
                        </div>

                        <div class="flex gap-2 mt-3 pt-3 border-t border-rose-100/60">
                            <a href="{{ route('projects.show', $project) }}"
                               class="flex-1 text-center py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs rounded-xl border border-rose-100 transition-all">
                                Abrir
                            </a>
                            @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}"
                                   class="px-3 py-1.5 bg-violet-50 hover:bg-violet-100 text-violet-600 text-xs rounded-xl border border-violet-100 transition-all">
                                    Editar
                                </a>
                            @endcan
                            @can('delete', $project)
                                <form action="{{ route('projects.destroy', $project) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este tablero?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs rounded-xl border border-rose-200 transition-all">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16 text-slate-400">
                    <div class="text-5xl mb-3">📋</div>
                    <p class="text-sm">
                        No hay tableros disponibles.
                    </p>
                    @can('crear proyecto')
                        <a href="{{ route('projects.create') }}"
                           class="inline-block mt-4 px-4 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl transition-all shadow-md shadow-rose-500/25">
                            Crear primer tablero
                        </a>
                    @endcan
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>