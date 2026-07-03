<x-app-layout>
    <x-slot name="header">
        <h1 class="text-rose-700 font-semibold text-lg">
            Inicio
        </h1>
    </x-slot>

    <div class="p-6">

        {{-- Bienvenida --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-rose-700 mb-1">
                Hola, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-slate-500 text-sm">
                Aquí tienes un resumen de tu actividad.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-rose-100 p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-slate-800">
                        {{ $totalProyectos }}
                    </p>
                    <p class="text-slate-500 text-sm">
                        Tableros
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-rose-100 p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 bg-pink-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-slate-800">
                        {{ $totalTareas }}
                    </p>
                    <p class="text-slate-500 text-sm">
                        Tareas asignadas
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-rose-100 p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 bg-violet-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-violet-500"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-slate-800">
                        {{ $completadas }}
                    </p>
                    <p class="text-slate-500 text-sm">
                        Completadas
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Tableros recientes --}}
            <div class="bg-white rounded-2xl border border-rose-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-800 font-medium text-sm">
                        Tableros recientes
                    </h3>
                    <a href="{{ route('projects.index') }}"
                       class="text-rose-500 hover:text-rose-600 text-xs transition-colors">
                        Ver todos
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse ($proyectosRecientes as $p)
                        <a href="{{ route('projects.show', $p) }}"
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-rose-50 transition-all group">
                            <span class="w-3 h-3 rounded-full flex-shrink-0 border border-rose-100"
                                  style="background-color: {{ $p->color }}"></span>
                            <span class="text-slate-600 text-sm group-hover:text-slate-900 transition-colors truncate flex-1">
                                {{ $p->nombre }}
                            </span>
                            <span class="text-slate-400 text-xs">
                                {{ $p->tasks()->count() }} tareas
                            </span>
                        </a>
                    @empty
                        <p class="text-slate-400 text-sm text-center py-4">
                            No hay tableros aún.
                        </p>
                    @endforelse
                </div>

                @can('crear proyecto')
                    <a href="{{ route('projects.create') }}"
                       class="mt-4 flex items-center justify-center gap-2 w-full py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 text-sm rounded-xl border border-rose-100 border-dashed transition-all">
                        + Crear tablero
                    </a>
                @endcan
            </div>

            {{-- Tareas recientes --}}
            <div class="bg-white rounded-2xl border border-rose-100 p-5 shadow-sm">
                <h3 class="text-slate-800 font-medium text-sm mb-4">
                    Tareas recientes
                </h3>
                <div class="space-y-2">
                    @forelse ($tareasRecientes as $t)
                        <a href="{{ route('tasks.show', $t) }}"
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-rose-50 transition-all group">
                            <span class="w-2 h-2 rounded-full flex-shrink-0
                                {{ $t->estado === 'pendiente' ? 'bg-slate-300' : '' }}
                                {{ $t->estado === 'en_progreso' ? 'bg-violet-400' : '' }}
                                {{ $t->estado === 'completada' ? 'bg-emerald-400' : '' }}">
                            </span>
                            <span class="text-slate-600 text-sm group-hover:text-slate-900 transition-colors truncate flex-1">
                                {{ $t->titulo }}
                            </span>
                            <span class="px-2 py-0.5 text-xs rounded-full flex-shrink-0
                                {{ $t->prioridad === 'alta' ? 'bg-rose-100 text-rose-600' : '' }}
                                {{ $t->prioridad === 'media' ? 'bg-amber-100 text-amber-600' : '' }}
                                {{ $t->prioridad === 'baja' ? 'bg-emerald-50 text-emerald-600' : '' }}">
                                {{ ucfirst($t->prioridad) }}
                            </span>
                        </a>
                    @empty
                        <p class="text-slate-400 text-sm text-center py-4">
                            No hay tareas asignadas.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Accesos rápidos --}}
        <div class="bg-white rounded-2xl border border-rose-100 p-5 mt-6 shadow-sm">
            <h3 class="text-slate-800 font-medium text-sm mb-4">
                Accesos rápidos
            </h3>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('projects.index') }}"
                   class="px-4 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                    Ver tableros
                </a>
                @can('crear proyecto')
                    <a href="{{ route('projects.create') }}"
                       class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl font-medium border border-rose-100 transition-all">
                        + Nuevo tablero
                    </a>
                @endcan
                @role('admin')
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 bg-violet-50 hover:bg-violet-100 text-violet-600 text-sm rounded-xl font-medium border border-violet-100 transition-all">
                        Gestionar usuarios
                    </a>
                @endrole
            </div>
        </div>

    </div>
</x-app-layout>