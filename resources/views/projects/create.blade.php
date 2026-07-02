<x-app-layout>
    <x-slot name="header">
        <h1 class="text-white font-semibold text-lg">Nuevo tablero</h1>
    </x-slot>

    <div class="p-6 max-w-2xl">
        <div class="bg-[#161B22] border border-white/10 rounded-xl p-6">
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Nombre del tablero</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                        focus:outline-none focus:border-blue-500 transition-all"
                        placeholder="Ej: Proyecto Web 2026" required />
                    @error('nombre')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                        focus:outline-none focus:border-blue-500 transition-all resize-none"
                        placeholder="Describe el objetivo del tablero...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Estado</label>
                        <select name="estado"
                            class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                            focus:outline-none focus:border-blue-500 transition-all">
                            @foreach (['activo', 'pausado', 'finalizado'] as $e)
                                <option value="{{ $e }}" @selected(old('estado', 'activo') === $e)>
                                    {{ ucfirst($e) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Color del tablero</label>
                        <div class="flex gap-2 flex-wrap mt-1">
                            @foreach (['#6366F1','#EC4899','#10B981','#F59E0B','#3B82F6','#8B5CF6','#EF4444','#06B6D4'] as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="{{ $c }}"
                                        @checked(old('color', '#6366F1') === $c) class="sr-only">
                                    <span class="block w-7 h-7 rounded-full border-2 transition-all
                                        {{ old('color', '#6366F1') === $c ? 'border-white scale-110' : 'border-transparent hover:border-white/50' }}"
                                        style="background-color: {{ $c }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all">
                        Crear tablero
                    </button>
                    <a href="{{ route('projects.index') }}"
                        class="px-5 py-2 bg-[#21262D] hover:bg-white/10 text-gray-300 text-sm rounded-lg border border-white/10 transition-all">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>