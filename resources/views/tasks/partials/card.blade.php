<div class="bg-white border border-rose-100 rounded-2xl p-3 hover:border-rose-200 hover:shadow-sm transition-all group">

    {{-- Etiquetas --}}
    @if ($task->labels->count())
        <div class="flex gap-1 flex-wrap mb-2">
            @foreach ($task->labels as $label)
                <span class="px-2 py-0.5 text-xs rounded-full text-white font-medium"
                      style="background-color: {{ $label->color }}">
                    {{ $label->nombre }}
                </span>
            @endforeach
        </div>
    @endif

    {{-- Título --}}
    <a href="{{ route('tasks.show', $task) }}"
       class="text-slate-700 text-sm font-medium hover:text-slate-900 transition-colors line-clamp-2 block mb-2">
        {{ $task->titulo }}
    </a>

    {{-- Prioridad y vencimiento --}}
    <div class="flex items-center gap-2 flex-wrap">
        <span class="px-2 py-0.5 text-xs rounded-full
            {{ $task->prioridad === 'alta' ? 'bg-rose-100 text-rose-600 border border-rose-200' : '' }}
            {{ $task->prioridad === 'media' ? 'bg-amber-100 text-amber-600 border border-amber-200' : '' }}
            {{ $task->prioridad === 'baja' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}">
            {{ ucfirst($task->prioridad) }}
        </span>

        @if ($task->due_date)
            <span class="text-xs {{ $task->isOverdue() ? 'text-rose-500' : 'text-slate-400' }}">
                📅 {{ $task->due_date->format('d/m/Y') }}
            </span>
        @endif

        {{-- Responsable --}}
        @if ($task->assignee)
            <div class="ml-auto w-5 h-5 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold"
                 title="{{ $task->assignee->name }}">
                {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
            </div>
        @endif
    </div>

    {{-- Cambio de estado rápido --}}
    @can('update', $task)
        <form action="{{ route('tasks.status', $task) }}" method="POST" class="mt-2">
            @csrf
            @method('PATCH')
            <select name="estado" onchange="this.form.submit()"
                    class="w-full bg-rose-50 border border-rose-100 text-slate-600 text-xs rounded-xl px-2 py-1
                    focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all cursor-pointer">
                @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                    <option value="{{ $e }}" @selected($task->estado === $e)>
                        {{ str_replace('_', ' ', ucfirst($e)) }}
                    </option>
                @endforeach
            </select>
        </form>
    @endcan
</div>