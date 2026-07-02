<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-2">
                <a href="{{ route('projects.show', $task->project) }}"
                    class="text-gray-400 hover:text-white text-sm transition-colors">
                    {{ $task->project->nombre }}
                </a>
                <span class="text-gray-600">/</span>
                <h1 class="text-white font-semibold text-lg">{{ $task->titulo }}</h1>
            </div>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="px-3 py-1.5 bg-[#21262D] hover:bg-white/10 text-gray-300 text-xs rounded-lg border border-white/10 transition-all">
                        Editar
                    </a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar esta tarea?')">
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Contenido principal --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Etiquetas --}}
                @if ($task->labels->count())
                    <div class="flex gap-2 flex-wrap">
                        @foreach ($task->labels as $label)
                            <span class="px-3 py-1 text-xs rounded-full text-white font-medium"
                                style="background-color: {{ $label->color }}">
                                {{ $label->nombre }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Descripción --}}
                <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                    <h3 class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-3">Descripción</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        {{ $task->descripcion ?? 'Sin descripción.' }}
                    </p>
                </div>

                {{-- Comentarios --}}
                <div class="bg-[#161B22] border border-white/10 rounded-xl p-5">
                    <h3 class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-4">
                        Comentarios ({{ $task->comments->count() }})
                    </h3>

                    <div class="space-y-4 mb-4">
                        @foreach ($task->comments as $comment)
                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-white text-xs font-medium">{{ $comment->user->name }}</span>
                                        <span class="text-gray-500 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}"
                                                method="POST" class="ml-auto"
                                                onsubmit="return confirm('¿Eliminar comentario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-400 hover:text-red-300 text-xs transition-colors">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                    <p class="text-gray-300 text-sm bg-[#0D1117] rounded-lg px-3 py-2">
                                        {{ $comment->cuerpo }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @can('create', [App\Models\Comment::class, $task])
                        <form action="{{ route('comments.store', $task) }}" method="POST" class="flex gap-3">
                            @csrf
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="cuerpo" rows="2"
                                    class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-3 py-2 text-sm
                                    focus:outline-none focus:border-blue-500 transition-all resize-none"
                                    placeholder="Escribe un comentario...">{{ old('cuerpo') }}</textarea>
                                @error('cuerpo')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit"
                                    class="mt-2 px-4 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs rounded-lg transition-all">
                                    Comentar
                                </button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>

            {{-- Sidebar de la tarea --}}
            <div class="space-y-4">

                {{-- Estado --}}
                <div class="bg-[#161B22] border border-white/10 rounded-xl p-4">
                    <h3 class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-3">Estado</h3>
                    @can('update', $task)
                        <form action="{{ route('tasks.status', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="estado" onchange="this.form.submit()"
                                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-3 py-2 text-sm
                                focus:outline-none focus:border-blue-500 transition-all cursor-pointer">
                                @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                    <option value="{{ $e }}" @selected($task->estado === $e)>
                                        {{ str_replace('_', ' ', ucfirst($e)) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            {{ str_replace('_', ' ', ucfirst($task->estado)) }}
                        </span>
                    @endcan
                </div>

                {{-- Detalles --}}
                <div class="bg-[#161B22] border border-white/10 rounded-xl p-4 space-y-3">
                    <h3 class="text-gray-400 text-xs font-medium uppercase tracking-wider">Detalles</h3>

                    <div>
                        <p class="text-gray-500 text-xs mb-1">Prioridad</p>
                        <span class="px-2 py-0.5 text-xs rounded-full
                            {{ $task->prioridad === 'alta' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}
                            {{ $task->prioridad === 'media' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
                            {{ $task->prioridad === 'baja' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}">
                            {{ ucfirst($task->prioridad) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-gray-500 text-xs mb-1">Responsable</p>
                        @if ($task->assignee)
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-300 text-sm">{{ $task->assignee->name }}</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-xs">Sin asignar</p>
                        @endif
                    </div>

                    @if ($task->due_date)
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Fecha límite</p>
                            <span class="text-sm {{ $task->isOverdue() ? 'text-red-400' : 'text-gray-300' }}">
                                {{ $task->due_date->format('d/m/Y') }}
                                @if ($task->isOverdue())
                                    <span class="text-xs">(vencida)</span>
                                @endif
                            </span>
                        </div>
                    @endif

                    <div>
                        <p class="text-gray-500 text-xs mb-1">Proyecto</p>
                        <a href="{{ route('projects.show', $task->project) }}"
                            class="text-blue-400 hover:text-blue-300 text-sm transition-colors">
                            {{ $task->project->nombre }}
                        </a>
                    </div>
                </div>

                {{-- Asignar responsable --}}
                @can('assign', $task)
                    <div class="bg-[#161B22] border border-white/10 rounded-xl p-4">
                        <h3 class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-3">Asignar</h3>
                        <form action="{{ route('tasks.assign', $task) }}" method="POST" class="space-y-2">
                            @csrf
                            @method('PATCH')
                            <select name="assignee_id"
                                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-3 py-2 text-sm
                                focus:outline-none focus:border-blue-500 transition-all">
                                <option value="">Sin asignar</option>
                                @foreach ($members as $m)
                                    <option value="{{ $m->id }}" @selected($task->assignee_id == $m->id)>
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="w-full py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs rounded-lg transition-all">
                                Asignar
                            </button>
                        </form>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>