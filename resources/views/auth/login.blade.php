<x-guest-layout>
    <x-auth-session-status class="mb-4 text-pink-600 text-sm" :status="session('status')" />

    <h2 class="text-rose-700 font-semibold text-xl mb-6 text-center">
        Iniciar sesión
    </h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-medium text-rose-500 mb-1">
                Correo electrónico
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                   class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all placeholder:text-slate-300"
                   placeholder="tu@correo.com" />
            @error('email')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ show: false }">
            <label for="password" class="block text-xs font-medium text-rose-500 mb-1">
                Contraseña
            </label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                       class="w-full bg-white border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                       focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all pr-10 placeholder:text-slate-300"
                       placeholder="••••••••" />
                <button type="button" @click="show = !show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-rose-400 hover:text-rose-600 transition-colors">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-xs text-slate-500 cursor-pointer">
                <input type="checkbox" name="remember"
                       class="rounded border-rose-200 bg-white text-rose-500 focus:ring-rose-400 focus:ring-offset-0">
                Recordarme
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-xs text-violet-500 hover:text-violet-400 transition-colors">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full py-2.5 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white font-semibold rounded-2xl text-sm
                transition-all duration-150 shadow-lg shadow-rose-500/25">
            Iniciar sesión
        </button>

        <p class="text-center text-xs text-slate-500 mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-rose-500 hover:text-rose-600 transition-colors font-medium">
                Regístrate
            </a>
        </p>
    </form>
</x-guest-layout>