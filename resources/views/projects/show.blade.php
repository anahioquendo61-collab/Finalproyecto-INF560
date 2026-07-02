<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <span class="w-4 h-4 rounded-sm flex-shrink-0"
                    style="background-color: {{ $project->color }}"></span>
                <h1 class="text-white font-semibold text-lg">{{ $project->nombre }}</h1>
                <span class="px-2 py-0.5 text-xs rounded-full
                    {{ $project->estado === 'activo' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                    {{ $project->estado === 'pausado' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
                    {{ $project->estado === 'finalizado' ? 'bg-gray-500/10 text-gray-400 border border-gray-500/20' : '' }}">
                    {{ ucfirst($project->estado) }}
                </span>
            </div>
            <div class="flex gap-2">
                @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}"
                    class="px-3 py-1.5 bg-[#21262D] hover:bg-white/10 text-gray-300 text-xs rounded-lg border border-white/10 transition-all">
                    Editar
                </a>
                @endcan
                @can('delete', $project)
                <form action="{{ route('projects.destroy', $project) }}" method="POST"
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
    </x-slot>

    <div class="p-6">

        {{-- Descripción y miembros --}}
        <div class="flex gap-4 mb-6 flex-wrap">
            @if ($project->descripcion)
            <p class="text-gray-400 text-sm">{{ $project->descripcion }}</p>
            @endif

            <div class="flex items-center gap-2 ml-auto">
                {{-- Avatares de miembros --}}
                <div class="flex -space-x-2">
                    @foreach ($project->members->take(5) as $member)
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold border-2 border-[#0D1117]"
                        title="{{ $member->name }}">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    @endforeach
                </div>

                @can('manageMembers', $project)
                <button onclick="document.getElementById('modal-members').classList.remove('hidden')"
                    class="px-3 py-1.5 bg-[#21262D] hover:bg-white/10 text-gray-300 text-xs rounded-lg border border-white/10 transition-all">
                    + Miembros
                </button>
                @endcan

                @can('create', [App\Models\Task::class, $project])
                <a href="{{ route('projects.tasks.create', $project) }}"
                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs rounded-lg transition-all">
                    + Nueva tarea
                </a>
                @endcan
            </div>
        </div>
        {{-- Filtro de prioridad --}}
        <form method="GET" action="{{ route('projects.show', $project) }}"
            class="flex gap-2 mb-4">
            <select name="prioridad"
                class="bg-[#161B22] border border-white/10 text-gray-300 text-sm rounded-lg px-4 py-2
        focus:outline-none focus:border-blue-500 transition-all">
                <option value="">Todas las prioridades</option>
                @foreach (['baja', 'media', 'alta'] as $p)
                <option value="{{ $p }}" @selected(request('prioridad')===$p)>
                    {{ ucfirst($p) }}
                </option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg transition-all">
                Filtrar
            </button>
            <a href="{{ route('projects.show', $project) }}"
                class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-gray-300 text-sm rounded-lg border border-white/10 transition-all">
                Limpiar
            </a>
        </form>
        {{-- Tablero Kanban --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Columna Pendiente --}}
            <div class="bg-[#161B22] border border-white/10 rounded-xl p-3">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-400"></div>
                    <h3 class="text-gray-300 font-medium text-sm">Pendiente</h3>
                    <span class="ml-auto text-xs text-gray-500 bg-white/5 px-2 py-0.5 rounded-full">
                        {{ $pendientes->count() }}
                    </span>
                </div>
                <div class="space-y-2">
                    @foreach ($pendientes as $task)
                    @include('tasks.partials.card', ['task' => $task])
                    @endforeach
                </div>
            </div>

            {{-- Columna En Progreso --}}
            <div class="bg-[#161B22] border border-white/10 rounded-xl p-3">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-2.5 h-2.5 rounded-full bg-blue-400"></div>
                    <h3 class="text-gray-300 font-medium text-sm">En progreso</h3>
                    <span class="ml-auto text-xs text-gray-500 bg-white/5 px-2 py-0.5 rounded-full">
                        {{ $enProgreso->count() }}
                    </span>
                </div>
                <div class="space-y-2">
                    @foreach ($enProgreso as $task)
                    @include('tasks.partials.card', ['task' => $task])
                    @endforeach
                </div>
            </div>

            {{-- Columna Completada --}}
            <div class="bg-[#161B22] border border-white/10 rounded-xl p-3">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                    <h3 class="text-gray-300 font-medium text-sm">Completada</h3>
                    <span class="ml-auto text-xs text-gray-500 bg-white/5 px-2 py-0.5 rounded-full">
                        {{ $completadas->count() }}
                    </span>
                </div>
                <div class="space-y-2">
                    @foreach ($completadas as $task)
                    @include('tasks.partials.card', ['task' => $task])
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Miembros --}}
    @can('manageMembers', $project)
    <div id="modal-members" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
        <div class="bg-[#161B22] border border-white/10 rounded-2xl shadow-2xl w-full max-w-md">
            <div class="flex items-center justify-between p-5 border-b border-white/10">
                <h3 class="text-white font-semibold">Gestionar miembros</h3>
                <button onclick="document.getElementById('modal-members').classList.add('hidden')"
                    class="text-gray-400 hover:text-white transition-colors">✕</button>
            </div>
            <div class="p-5 space-y-4">
                {{-- Lista de miembros --}}
                @foreach ($project->members as $member)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-white text-sm">{{ $member->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $member->pivot->project_role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('projects.members.destroy', [$project, $member]) }}"
                        method="POST" onsubmit="return confirm('¿Quitar este miembro?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 text-xs transition-colors">
                            Quitar
                        </button>
                    </form>
                </div>
                @endforeach

                {{-- Agregar miembro --}}
                <form action="{{ route('projects.members.store', $project) }}" method="POST"
                    class="pt-4 border-t border-white/10 space-y-3">
                    @csrf
                    <select name="user_id"
                        class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="">Selecciona usuario</option>
                        @foreach (\App\Models\User::all() as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    <select name="project_role"
                        class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="colaborador">Colaborador</option>
                        <option value="lider">Líder</option>
                        <option value="invitado">Invitado</option>
                    </select>
                    <button type="submit"
                        class="w-full py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all">
                        Agregar miembro
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endcan

</x-app-layout>