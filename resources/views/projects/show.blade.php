<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <span class="w-4 h-4 rounded-sm flex-shrink-0"
                      style="background-color: {{ $project->color }}"></span>
                <h1 class="text-rose-700 font-semibold text-lg">
                    {{ $project->nombre }}
                </h1>
                <span class="px-2 py-0.5 text-xs rounded-full
                    {{ $project->estado === 'activo' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                    {{ $project->estado === 'pausado' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                    {{ $project->estado === 'finalizado' ? 'bg-slate-50 text-slate-500 border border-slate-200' : '' }}">
                    {{ ucfirst($project->estado) }}
                </span>
            </div>
            <div class="flex gap-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}"
                       class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs rounded-xl border border-rose-100 transition-all">
                        Editar
                    </a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
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
    </x-slot>

    <div class="p-6">

        {{-- Descripción y miembros --}}
        <div class="flex gap-4 mb-6 flex-wrap items-center">
            @if ($project->descripcion)
                <p class="text-slate-500 text-sm max-w-xl">
                    {{ $project->descripcion }}
                </p>
            @endif

            <div class="flex items-center gap-2 ml-auto">
                {{-- Avatares de miembros --}}
                <div class="flex -space-x-2">
                    @foreach ($project->members->take(5) as $member)
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white"
                             title="{{ $member->name }}">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                    @endforeach
                </div>

                @can('manageMembers', $project)
                    <button onclick="document.getElementById('modal-members').classList.remove('hidden')"
                            class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs rounded-xl border border-rose-100 transition-all">
                        + Miembros
                    </button>
                @endcan

                @can('create', [App\Models\Task::class, $project])
                    <a href="{{ route('projects.tasks.create', $project) }}"
                       class="px-3 py-1.5 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-xs rounded-2xl transition-all shadow-md shadow-rose-500/25">
                        + Nueva tarea
                    </a>
                @endcan
            </div>
        </div>

        {{-- Filtro de prioridad --}}
        <form method="GET" action="{{ route('projects.show', $project) }}"
              class="flex gap-2 mb-4">
            <select name="prioridad"
                    class="bg-white border border-rose-100 text-slate-600 text-sm rounded-xl px-4 py-2
                    focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                <option value="">Todas las prioridades</option>
                @foreach (['baja', 'media', 'alta'] as $p)
                    <option value="{{ $p }}" @selected(request('prioridad')===$p)>
                        {{ ucfirst($p) }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm rounded-xl transition-all shadow-sm shadow-rose-500/20">
                Filtrar
            </button>
            <a href="{{ route('projects.show', $project) }}"
               class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl border border-rose-100 transition-all">
                Limpiar
            </a>
        </form>

        {{-- Tablero Kanban --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Columna Pendiente --}}
            <div class="bg-white border border-rose-100 rounded-2xl p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                    <h3 class="text-slate-700 font-medium text-sm">
                        Pendiente
                    </h3>
                    <span class="ml-auto text-xs text-slate-500 bg-rose-50 px-2 py-0.5 rounded-full">
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
            <div class="bg-white border border-rose-100 rounded-2xl p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-2.5 h-2.5 rounded-full bg-violet-400"></div>
                    <h3 class="text-slate-700 font-medium text-sm">
                        En progreso
                    </h3>
                    <span class="ml-auto text-xs text-slate-500 bg-rose-50 px-2 py-0.5 rounded-full">
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
            <div class="bg-white border border-rose-100 rounded-2xl p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                    <h3 class="text-slate-700 font-medium text-sm">
                        Completada
                    </h3>
                    <span class="ml-auto text-xs text-slate-500 bg-rose-50 px-2 py-0.5 rounded-full">
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
        <div id="modal-members" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
            <div class="bg-white border border-rose-100 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-5 border-b border-rose-100">
                    <h3 class="text-slate-800 font-semibold text-sm">
                        Gestionar miembros
                    </h3>
                    <button onclick="document.getElementById('modal-members').classList.add('hidden')"
                            class="text-slate-400 hover:text-slate-600 transition-colors text-sm">
                        ✕
                    </button>
                </div>
                <div class="p-5 space-y-4">
                    {{-- Lista de miembros --}}
                    @foreach ($project->members as $member)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-slate-800 text-sm">
                                        {{ $member->name }}
                                    </p>
                                    <p class="text-slate-400 text-xs">
                                        {{ $member->pivot->project_role }}
                                    </p>
                                </div>
                            </div>
                            <form action="{{ route('projects.members.destroy', [$project, $member]) }}"
                                  method="POST" onsubmit="return confirm('¿Quitar este miembro?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-500 hover:text-rose-600 text-xs transition-colors">
                                    Quitar
                                </button>
                            </form>
                        </div>
                    @endforeach

                    {{-- Agregar miembro --}}
                    <form action="{{ route('projects.members.store', $project) }}" method="POST"
                          class="pt-4 border-t border-rose-100 space-y-3">
                        @csrf
                        <select name="user_id"
                                class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200">
                            <option value="">Selecciona usuario</option>
                            @foreach (\App\Models\User::all() as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <select name="project_role"
                                class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200">
                            <option value="colaborador">Colaborador</option>
                            <option value="lider">Líder</option>
                            <option value="invitado">Invitado</option>
                        </select>
                        <button type="submit"
                                class="w-full py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                            Agregar miembro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endcan

</x-app-layout>