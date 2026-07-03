<section>
    <header class="mb-5">
        <h2 class="text-rose-700 font-medium">
            Actualizar contraseña
        </h2>
        <p class="text-slate-500 text-xs mt-1">
            Usa una contraseña larga y aleatoria para mantener tu cuenta segura.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label class="block text-xs font-medium text-rose-500 mb-1">
                Contraseña actual
            </label>
            <input type="password" name="current_password"
                   class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all" />
            @error('current_password', 'updatePassword')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-rose-500 mb-1">
                Nueva contraseña
            </label>
            <input type="password" name="password"
                   class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all" />
            @error('password', 'updatePassword')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-rose-500 mb-1">
                Confirmar contraseña
            </label>
            <input type="password" name="password_confirmation"
                   class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="px-5 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                Actualizar
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-emerald-500 text-xs">
                    Contraseña actualizada.
                </p>
            @endif
        </div>
    </form>
</section>