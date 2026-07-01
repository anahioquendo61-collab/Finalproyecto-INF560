<x-guest-layout>
    <h2 class="text-white font-semibold text-xl mb-6 text-center">Crear cuenta</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-medium text-gray-400 mb-1">
                Nombre completo
            </label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                placeholder="Tu nombre" />
            @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-medium text-gray-400 mb-1">
                Correo electrónico
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required
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

        <div>
            <label for="password_confirmation" class="block text-xs font-medium text-gray-400 mb-1">
                Confirmar contraseña
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                placeholder="••••••••" />
            @error('password_confirmation')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg text-sm
            transition-all duration-150 shadow-lg shadow-blue-500/20">
            Crear cuenta
        </button>

        <p class="text-center text-xs text-gray-500 mt-4">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                Inicia sesión
            </a>
        </p>
    </form>
</x-guest-layout>