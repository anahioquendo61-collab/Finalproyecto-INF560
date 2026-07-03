<section>
    <header class="mb-5">
        <h2 class="text-rose-700 font-medium">
            Información de perfil
        </h2>
        <p class="text-slate-500 text-xs mt-1">
            Actualiza tu nombre y dirección de correo electrónico.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div>
            <label class="block text-xs font-medium text-rose-500 mb-1">
                Nombre
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all"
                   required />
            @error('name')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-rose-500 mb-1">
                Correo electrónico
            </label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all"
                   required />
            @error('email')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="px-5 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-sm rounded-2xl font-medium transition-all shadow-md shadow-rose-500/25">
                Guardar
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-emerald-500 text-xs">
                    Guardado correctamente.
                </p>
            @endif
        </div>
    </form>
</section>