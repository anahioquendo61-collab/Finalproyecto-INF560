<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-white font-semibold text-lg">Tableros</h1>
            @can('crear proyecto')
                <a href="{{ route('projects.create') }}"
                    class="px-4 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all">
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
                class="bg-[#161B22] border border-white/10 text-white text-sm rounded-lg px-4 py-2 w-56
                focus:outline-none focus:border-blue-500 transition-all" />
            <select name="estado"
                class="bg-[#161B22] border border-white/10 text-gray-300 text-sm rounded-lg px-4 py-2
                focus:outline-none focus:border-blue-500 transition-all">
                <option value="">Todos los estados</option>
                @foreach (['activo', 'pausado', 'finalizado'] as $e)
                    <option value="{{ $e }}" @selected(request('estado') === $e)>
                        {{ ucfirst($e) }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg transition-all">
                Filtrar
            </button>
            <a href="{{ route('projects.index') }}"
                class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-gray-300 text-sm rounded-lg border border-white/10 transition-all">
                Limpiar
            </a>
        </form>

        {{-- Grid de tableros estilo Trello --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($projects as $project)
                <div class="bg-[#161B22] border border-white/10 rounded-xl overflow-hidden hover:border-white/20 transition-all group">

                    {{-- Header del tablero con color --}}
                    <div class="h-20 relative flex items-end p-3"
                        style="background-color: {{ $project->color }}">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="relative z-10">
                            <span class="text-xs text-white/80 font-medium px-2 py-0.5 bg-black/30 rounded-full">
                                {{ ucfirst($project->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="text-white font-semibold text-sm mb-1 truncate">
                            {{ $project->nombre }}
                        </h3>
                        <p class="text-gray-500 text-xs mb-3 line-clamp-2">
                            {{ $project->descripcion ?? 'Sin descripción.' }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $project->tasks()->count() }} tareas</span>
                            <span>{{ $project->members()->count() }} miembros</span>
                        </div>

                        <div class="flex gap-2 mt-3 pt-3 border-t border-white/5">
                            <a href="{{ route('projects.show', $project) }}"
                                class="flex-1 text-center py-1.5 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-xs rounded-lg border border-blue-600/20 transition-all">
                                Abrir
                            </a>
                            @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}"
                                    class="px-3 py-1.5 bg-white/5 hover:bg-white/10 text-gray-400 text-xs rounded-lg border border-white/10 transition-all">
                                    Editar
                                </a>
                            @endcan
                            @can('delete', $project)
                                <form action="{{ route('projects.destroy', $project) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar este tablero?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs rounded-lg border border-red-500/20 transition-all">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16 text-gray-500">
                    <div class="text-5xl mb-3">📋</div>
                    <p class="text-sm">No hay tableros disponibles.</p>
                    @can('crear proyecto')
                        <a href="{{ route('projects.create') }}"
                            class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg transition-all">
                            Crear primer tablero
                        </a>
                    @endcan
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $projects->links() }}</div>
    </div>
</x-app-layout>