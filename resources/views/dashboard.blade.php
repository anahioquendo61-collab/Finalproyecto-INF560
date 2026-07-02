<x-app-layout>
    <x-slot name="header">
        <h1 class="text-white font-semibold text-lg">Inicio</h1>
    </x-slot>

    <div class="p-6">

        {{-- Bienvenida --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white mb-1">
                Hola, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-gray-400 text-sm">
                Aquí tienes un resumen de tu actividad.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">{{ $totalProyectos }}</p>
                    <p class="text-gray-400 text-sm">Tableros</p>
                </div>
            </div>

            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">{{ $totalTareas }}</p>
                    <p class="text-gray-400 text-sm">Tareas asignadas</p>
                </div>
            </div>

            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">{{ $completadas }}</p>
                    <p class="text-gray-400 text-sm">Completadas</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Tableros recientes --}}
            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-medium text-sm">Tableros recientes</h3>
                    <a href="{{ route('projects.index') }}"
                        class="text-blue-400 hover:text-blue-300 text-xs transition-colors">
                        Ver todos
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse ($proyectosRecientes as $p)
                        <a href="{{ route('projects.show', $p) }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition-all group">
                            <span class="w-3 h-3 rounded-sm flex-shrink-0"
                                style="background-color: {{ $p->color }}"></span>
                            <span class="text-gray-300 text-sm group-hover:text-white transition-colors truncate flex-1">
                                {{ $p->nombre }}
                            </span>
                            <span class="text-gray-500 text-xs">
                                {{ $p->tasks()->count() }} tareas
                            </span>
                        </a>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">
                            No hay tableros aún.
                        </p>
                    @endforelse
                </div>

                @can('crear proyecto')
                    <a href="{{ route('projects.create') }}"
                        class="mt-4 flex items-center justify-center gap-2 w-full py-2 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white text-sm rounded-lg border border-white/10 border-dashed transition-all">
                        + Crear tablero
                    </a>
                @endcan
            </div>

            {{-- Tareas recientes --}}
            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                <h3 class="text-white font-medium text-sm mb-4">Tareas recientes</h3>
                <div class="space-y-2">
                    @forelse ($tareasRecientes as $t)
                        <a href="{{ route('tasks.show', $t) }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition-all group">
                            <span class="w-2 h-2 rounded-full flex-shrink-0
                                {{ $t->estado === 'pendiente' ? 'bg-gray-400' : '' }}
                                {{ $t->estado === 'en_progreso' ? 'bg-blue-400' : '' }}
                                {{ $t->estado === 'completada' ? 'bg-green-400' : '' }}">
                            </span>
                            <span class="text-gray-300 text-sm group-hover:text-white transition-colors truncate flex-1">
                                {{ $t->titulo }}
                            </span>
                            <span class="px-2 py-0.5 text-xs rounded-full flex-shrink-0
                                {{ $t->prioridad === 'alta' ? 'bg-red-500/10 text-red-400' : '' }}
                                {{ $t->prioridad === 'media' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
                                {{ $t->prioridad === 'baja' ? 'bg-green-500/10 text-green-400' : '' }}">
                                {{ ucfirst($t->prioridad) }}
                            </span>
                        </a>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">
                            No hay tareas asignadas.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Accesos rápidos --}}
        <div class="bg-[#161B22] border border-white/10 rounded-xl p-5 mt-6">
            <h3 class="text-white font-medium text-sm mb-4">Accesos rápidos</h3>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('projects.index') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all">
                    Ver tableros
                </a>
                @can('crear proyecto')
                    <a href="{{ route('projects.create') }}"
                        class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-white text-sm rounded-lg font-medium border border-white/10 transition-all">
                        + Nuevo tablero
                    </a>
                @endcan
                @role('admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-white text-sm rounded-lg font-medium border border-white/10 transition-all">
                        Gestionar usuarios
                    </a>
                @endrole
            </div>
        </div>

    </div>
</x-app-layout>