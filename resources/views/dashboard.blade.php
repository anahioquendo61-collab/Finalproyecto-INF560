<x-app-layout>
    <x-slot name="header">
        <h1 class="text-white font-semibold text-lg">Inicio</h1>
    </x-slot>

    <div class="p-6">

        {{-- Bienvenida --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-1">
                Hola, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-gray-400 text-sm">
                Bienvenido a tu espacio de trabajo. Aquí tienes un resumen de tu actividad.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            @php
                $user = auth()->user();
                $totalProyectos = $user->hasRole('admin')
                    ? \App\Models\Project::count()
                    : $user->allProjects()->count();
                $totalTareas = $user->hasRole('admin')
                    ? \App\Models\Task::count()
                    : $user->assignedTasks()->count();
                $completadas = $user->hasRole('admin')
                    ? \App\Models\Task::where('estado', 'completada')->count()
                    : $user->assignedTasks()->where('estado', 'completada')->count();
            @endphp

            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <span class="text-gray-400 text-sm">Tableros</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ $totalProyectos }}</p>
            </div>

            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="text-gray-400 text-sm">Tareas asignadas</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ $totalTareas }}</p>
            </div>

            <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-green-500/10 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-gray-400 text-sm">Completadas</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ $completadas }}</p>
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="bg-[#161B22] border border-white/10 rounded-xl p-5 mb-6">
            <h3 class="text-white font-medium text-sm mb-4">Accesos rápidos</h3>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('projects.index') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all duration-150">
                    Ver tableros
                </a>
                @can('crear proyecto')
                <a href="{{ route('projects.create') }}"
                    class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-white text-sm rounded-lg font-medium border border-white/10 transition-all duration-150">
                    + Nuevo tablero
                </a>
                @endcan
                @role('admin')
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-white text-sm rounded-lg font-medium border border-white/10 transition-all duration-150">
                    Gestionar usuarios
                </a>
                @endrole
            </div>
        </div>

    </div>
</x-app-layout>