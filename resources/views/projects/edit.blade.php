<x-app-layout>
    <x-slot name="header">
        <h1 class="text-rose-700 font-semibold text-lg">
            Editar tablero
        </h1>
    </x-slot>

    <div class="p-6 max-w-2xl">
        <div class="bg-white border border-rose-100 rounded-2xl p-6 shadow-sm">
            <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-rose-500 mb-1">
                        Nombre del tablero
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $project->nombre) }}"
                           class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                           focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all" required />
                    @error('nombre')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-rose-500 mb-1">
                        Descripción
                    </label>
                    <textarea name="descripcion" rows="3"
                              class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all resize-none">{{ old('descripcion', $project->descripcion) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-rose-500 mb-1">
                            Estado
                        </label>
                        <select name="estado"
                                class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                                focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                            @foreach (['activo', 'pausado', 'finalizado'] as $e)
                                <option value="{{ $e }}" @selected(old('estado', $project->estado) === $e)>
                                    {{ ucfirst($e) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-rose-500 mb-1">
                            Color
                        </label>
                        <div class="flex gap-2 flex-wrap mt-1">
                            @foreach (['#6366F1','#EC4899','#10B981','#F59E0B','#3B82F6','#8B5CF6','#EF4444','#06B6D4'] as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="{{ $c }}"
                                           @checked(old('color', $project->color) === $c) class="sr-only">
                                    <span class="block w-7 h-7 rounded-full border-2 transition-all
                                        {{ old('color', $project->color) === $c ? 'border-rose-400 scale-110' : 'border-transparent hover:border-rose-200' }}"
                                          style="background-color: {{ $c }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                        Actualizar
                    </button>
                    <a href="{{ route('projects.show', $project) }}"
                       class="px-5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl border border-rose-100 transition-all">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>