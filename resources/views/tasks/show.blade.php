<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-2">
                <a href="{{ route('projects.show', $task->project) }}"
                   class="text-rose-500 hover:text-rose-600 text-sm transition-colors">
                    {{ $task->project->nombre }}
                </a>
                <span class="text-slate-300">/</span>
                <h1 class="text-rose-700 font-semibold text-lg">
                    {{ $task->titulo }}
                </h1>
            </div>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}"
                       class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs rounded-xl border border-rose-100 transition-all">
                        Editar
                    </a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar esta tarea?')">
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
                <div class="bg-white border border-rose-100 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-rose-500 text-xs font-medium uppercase tracking-wider mb-3">
                        Descripción
                    </h3>
                    <p class="text-slate-700 text-sm leading-relaxed">
                        {{ $task->descripcion ?? 'Sin descripción.' }}
                    </p>
                </div>

                {{-- Comentarios --}}
                <div class="bg-white border border-rose-100 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-rose-500 text-xs font-medium uppercase tracking-wider mb-4">
                        Comentarios ({{ $task->comments->count() }})
                    </h3>

                    <div class="space-y-4 mb-4">
                        @foreach ($task->comments as $comment)
                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-slate-800 text-xs font-medium">
                                            {{ $comment->user->name }}
                                        </span>
                                        <span class="text-slate-400 text-xs">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}"
                                                  method="POST" class="ml-auto"
                                                  onsubmit="return confirm('¿Eliminar comentario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-rose-500 hover:text-rose-600 text-xs transition-colors">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                    <p class="text-slate-700 text-sm bg-rose-50 rounded-xl px-3 py-2">
                                        {{ $comment->cuerpo }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @can('create', [App\Models\Comment::class, $task])
                        <form action="{{ route('comments.store', $task) }}" method="POST" class="flex gap-3">
                            @csrf
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="cuerpo" rows="2"
                                          class="w-full bg-rose-50 border border-rose-100 text-slate-700 rounded-xl px-3 py-2 text-sm
                                          focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all resize-none"
                                          placeholder="Escribe un comentario...">{{ old('cuerpo') }}</textarea>
                                @error('cuerpo')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit"
                                        class="mt-2 px-4 py-1.5 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-xs rounded-2xl transition-all shadow-md shadow-rose-500/25">
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
                <div class="bg-white border border-rose-100 rounded-2xl p-4 shadow-sm">
                    <h3 class="text-rose-500 text-xs font-medium uppercase tracking-wider mb-3">
                        Estado
                    </h3>
                    @can('update', $task)
                        <form action="{{ route('tasks.status', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="estado" onchange="this.form.submit()"
                                    class="w-full bg-rose-50 border border-rose-100 text-slate-700 rounded-xl px-3 py-2 text-sm
                                    focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all cursor-pointer">
                                @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                    <option value="{{ $e }}" @selected($task->estado === $e)>
                                        {{ str_replace('_', ' ', ucfirst($e)) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-rose-50 text-rose-600 border border-rose-100">
                            {{ str_replace('_', ' ', ucfirst($task->estado)) }}
                        </span>
                    @endcan
                </div>

                {{-- Detalles --}}
                <div class="bg-white border border-rose-100 rounded-2xl p-4 shadow-sm space-y-3">
                    <h3 class="text-rose-500 text-xs font-medium uppercase tracking-wider">
                        Detalles
                    </h3>

                    <div>
                        <p class="text-slate-400 text-xs mb-1">Prioridad</p>
                        <span class="px-2 py-0.5 text-xs rounded-full
                            {{ $task->prioridad === 'alta' ? 'bg-rose-100 text-rose-600 border border-rose-200' : '' }}
                            {{ $task->prioridad === 'media' ? 'bg-amber-100 text-amber-600 border border-amber-200' : '' }}
                            {{ $task->prioridad === 'baja' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}">
                            {{ ucfirst($task->prioridad) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-slate-400 text-xs mb-1">Responsable</p>
                        @if ($task->assignee)
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                </div>
                                <span class="text-slate-700 text-sm">
                                    {{ $task->assignee->name }}
                                </span>
                            </div>
                        @else
                            <p class="text-slate-400 text-xs">Sin asignar</p>
                        @endif
                    </div>

                    @if ($task->due_date)
                        <div>
                            <p class="text-slate-400 text-xs mb-1">Fecha límite</p>
                            <span class="text-sm {{ $task->isOverdue() ? 'text-rose-500' : 'text-slate-700' }}">
                                {{ $task->due_date->format('d/m/Y') }}
                                @if ($task->isOverdue())
                                    <span class="text-xs">(vencida)</span>
                                @endif
                            </span>
                        </div>
                    @endif

                    <div>
                        <p class="text-slate-400 text-xs mb-1">Proyecto</p>
                        <a href="{{ route('projects.show', $task->project) }}"
                           class="text-rose-500 hover:text-rose-600 text-sm transition-colors">
                            {{ $task->project->nombre }}
                        </a>
                    </div>
                </div>

                {{-- Asignar responsable --}}
                @can('assign', $task)
                    <div class="bg-white border border-rose-100 rounded-2xl p-4 shadow-sm">
                        <h3 class="text-rose-500 text-xs font-medium uppercase tracking-wider mb-3">
                            Asignar
                        </h3>
                        <form action="{{ route('tasks.assign', $task) }}" method="POST" class="space-y-2">
                            @csrf
                            @method('PATCH')
                            <select name="assignee_id"
                                    class="w-full bg-rose-50 border border-rose-100 text-slate-700 rounded-xl px-3 py-2 text-sm
                                    focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                                <option value="">Sin asignar</option>
                                @foreach ($members as $m)
                                    <option value="{{ $m->id }}" @selected($task->assignee_id == $m->id)>
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="w-full py-1.5 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-xs rounded-2xl transition-all shadow-md shadow-rose-500/25">
                                Asignar
                            </button>
                        </form>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>