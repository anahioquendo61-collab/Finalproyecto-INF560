<x-app-layout>
    <x-slot name="header">
        <h1 class="text-rose-700 font-semibold text-lg">
            Editar tarea
        </h1>
    </x-slot>

    <div class="p-6 max-w-2xl">
        <div class="bg-white border border-rose-100 rounded-2xl p-6 shadow-sm">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-rose-500 mb-1">
                        Título
                    </label>
                    <input type="text" name="titulo" value="{{ old('titulo', $task->titulo) }}"
                           class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                           focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all" required />
                    @error('titulo')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-rose-500 mb-1">
                        Descripción
                    </label>
                    <textarea name="descripcion" rows="3"
                              class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all resize-none">{{ old('descripcion', $task->descripcion) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-rose-500 mb-1">
                            Estado
                        </label>
                        <select name="estado"
                                class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                                focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                            @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                <option value="{{ $e }}" @selected(old('estado', $task->estado) === $e)>
                                    {{ str_replace('_', ' ', ucfirst($e)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-rose-500 mb-1">
                            Prioridad
                        </label>
                        <select name="prioridad"
                                class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                                focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                            @foreach (['baja', 'media', 'alta'] as $p)
                                <option value="{{ $p }}" @selected(old('prioridad', $task->prioridad) === $p)>
                                    {{ ucfirst($p) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-rose-500 mb-1">
                            Fecha límite
                        </label>
                        <input type="date" name="due_date"
                               value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                               class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                               focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-rose-500 mb-1">
                            Responsable
                        </label>
                        <select name="assignee_id"
                                class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                                focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                            <option value="">Sin asignar</option>
                            @foreach ($members as $m)
                                <option value="{{ $m->id }}"
                                        @selected(old('assignee_id', $task->assignee_id) == $m->id)>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-rose-500 mb-2">
                        Etiquetas
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($labels as $label)
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="labels[]" value="{{ $label->id }}"
                                       @checked(in_array($label->id, old('labels', $task->labels->pluck('id')->toArray())))
                                       class="rounded border-rose-200 bg-white text-rose-500 focus:ring-rose-400 focus:ring-offset-0">
                                <span class="px-2 py-0.5 text-xs rounded-full text-white"
                                      style="background-color: {{ $label->color }}">
                                    {{ $label->nombre }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                        Actualizar
                    </button>
                    <a href="{{ route('tasks.show', $task) }}"
                       class="px-5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl border border-rose-100 transition-all">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>