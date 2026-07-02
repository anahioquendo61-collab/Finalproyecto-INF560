<section>
    <header class="mb-5">
        <h2 class="text-white font-medium">Información de perfil</h2>
        <p class="text-gray-400 text-xs mt-1">
            Actualiza tu nombre y dirección de correo electrónico.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 transition-all" required />
            @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 transition-all" required />
            @error('email')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all">
                Guardar
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-green-400 text-xs">
                    Guardado correctamente.
                </p>
            @endif
        </div>
    </form>
</section>