<div class="bg-[#0D1117] border border-white/10 rounded-lg p-3 hover:border-white/20 transition-all group">

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
        class="text-gray-200 text-sm font-medium hover:text-white transition-colors line-clamp-2 block mb-2">
        {{ $task->titulo }}
    </a>

    {{-- Prioridad y vencimiento --}}
    <div class="flex items-center gap-2 flex-wrap">
        <span class="px-2 py-0.5 text-xs rounded-full
            {{ $task->prioridad === 'alta' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}
            {{ $task->prioridad === 'media' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : '' }}
            {{ $task->prioridad === 'baja' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}">
            {{ ucfirst($task->prioridad) }}
        </span>

        @if ($task->due_date)
            <span class="text-xs {{ $task->isOverdue() ? 'text-red-400' : 'text-gray-500' }}">
                📅 {{ $task->due_date->format('d/m/Y') }}
            </span>
        @endif

        {{-- Responsable --}}
        @if ($task->assignee)
            <div class="ml-auto w-5 h-5 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold"
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
                class="w-full bg-[#161B22] border border-white/10 text-gray-400 text-xs rounded-lg px-2 py-1
                focus:outline-none focus:border-blue-500 transition-all cursor-pointer">
                @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                    <option value="{{ $e }}" @selected($task->estado === $e)>
                        {{ str_replace('_', ' ', ucfirst($e)) }}
                    </option>
                @endforeach
            </select>
        </form>
    @endcan
</div>