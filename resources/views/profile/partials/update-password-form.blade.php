<section>
    <header class="mb-5">
        <h2 class="text-white font-medium">Actualizar contraseña</h2>
        <p class="text-gray-400 text-xs mt-1">
            Usa una contraseña larga y aleatoria para mantener tu cuenta segura.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Contraseña actual</label>
            <input type="password" name="current_password"
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 transition-all" />
            @error('current_password', 'updatePassword')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Nueva contraseña</label>
            <input type="password" name="password"
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 transition-all" />
            @error('password', 'updatePassword')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation"
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 transition-all" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg font-medium transition-all">
                Actualizar
            </button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-green-400 text-xs">
                    Contraseña actualizada.
                </p>
            @endif
        </div>
    </form>
</section>