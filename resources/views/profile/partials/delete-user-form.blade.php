<section>
    <header class="mb-5">
        <h2 class="text-rose-700 font-medium">
            Eliminar cuenta
        </h2>
        <p class="text-slate-500 text-xs mt-1">
            Una vez eliminada, todos tus datos serán borrados permanentemente.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl border border-rose-200 transition-all">
        Eliminar cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
              class="p-6 bg-white border border-rose-100 rounded-2xl shadow-lg max-w-md mx-auto">
            @csrf
            @method('delete')

            <h2 class="text-rose-700 font-medium mb-2">
                ¿Estás seguro?
            </h2>
            <p class="text-slate-600 text-sm mb-4">
                Esta acción es irreversible. Ingresa tu contraseña para confirmar.
            </p>

            <input type="password" name="password"
                   class="w-full bg-rose-50 border border-rose-100 text-slate-700 rounded-xl px-4 py-2.5 text-sm
                   focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all mb-4"
                   placeholder="Contraseña" />
            @error('password', 'userDeletion')
                <p class="text-rose-500 text-xs mb-4">
                    {{ $message }}
                </p>
            @enderror

            <div class="flex justify-end gap-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm rounded-xl border border-rose-100 transition-all">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-xl transition-all shadow-sm shadow-red-500/30">
                    Eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>