<x-guest-layout>
    <x-auth-session-status class="mb-4 text-green-400 text-sm" :status="session('status')" />

    <h2 class="text-white font-semibold text-xl mb-6 text-center">Iniciar sesión</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-medium text-gray-400 mb-1">
                Correo electrónico
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                placeholder="tu@correo.com" />
            @error('email')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ show: false }">
            <label for="password" class="block text-xs font-medium text-gray-400 mb-1">
                Contraseña
            </label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                    class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
            focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all pr-10"
                    placeholder="••••••••" />
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('password')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>  

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-xs text-gray-400 cursor-pointer">
                <input type="checkbox" name="remember"
                    class="rounded border-white/20 bg-[#0D1117] text-blue-500 focus:ring-blue-500">
                Recordarme
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-xs text-blue-400 hover:text-blue-300 transition-colors">
                ¿Olvidaste tu contraseña?
            </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg text-sm
            transition-all duration-150 shadow-lg shadow-blue-500/20">
            Iniciar sesión
        </button>

        <p class="text-center text-xs text-gray-500 mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                Regístrate
            </a>
        </p>
    </form>
</x-guest-layout>