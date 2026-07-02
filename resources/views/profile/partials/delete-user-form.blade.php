<section>
    <header class="mb-5">
        <h2 class="text-white font-medium">Eliminar cuenta</h2>
        <p class="text-gray-400 text-xs mt-1">
            Una vez eliminada, todos tus datos serán borrados permanentemente.
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-sm rounded-lg border border-red-500/20 transition-all">
        Eliminar cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#161B22]">
            @csrf
            @method('delete')

            <h2 class="text-white font-medium mb-2">¿Estás seguro?</h2>
            <p class="text-gray-400 text-sm mb-4">
                Esta acción es irreversible. Ingresa tu contraseña para confirmar.
            </p>

            <input type="password" name="password"
                class="w-full bg-[#0D1117] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm
                focus:outline-none focus:border-blue-500 transition-all mb-4"
                placeholder="Contraseña" />
            @error('password', 'userDeletion')
                <p class="text-red-400 text-xs mb-4">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 bg-[#21262D] hover:bg-white/10 text-gray-300 text-sm rounded-lg border border-white/10 transition-all">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-sm rounded-lg transition-all">
                    Eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>