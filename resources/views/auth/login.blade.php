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

        <div>
            <label for="password" class="block text-xs font-medium text-gray-400 mb-1">
                Contraseña
            </label>
            <input id="password" type="password" name="password" required
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                placeholder="••••••••" />
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