<x-app-layout>
    <x-slot name="header">
        <h1 class="text-rose-700 font-semibold text-lg">
            Administración de usuarios
        </h1>
    </x-slot>

    <div class="p-6">
        <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-rose-50 border-b border-rose-100">
                    <tr>
                        <th class="py-3 px-4 text-rose-500 text-xs font-medium uppercase tracking-wider">
                            Usuario
                        </th>
                        <th class="py-3 px-4 text-rose-500 text-xs font-medium uppercase tracking-wider">
                            Email
                        </th>
                        <th class="py-3 px-4 text-rose-500 text-xs font-medium uppercase tracking-wider">
                            Rol actual
                        </th>
                        <th class="py-3 px-4 text-rose-500 text-xs font-medium uppercase tracking-wider">
                            Cambiar rol
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-rose-50 hover:bg-rose-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-slate-700 text-sm">
                                        {{ $user->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-sm">
                                {{ $user->email }}
                            </td>
                            <td class="py-3 px-4">
                                @php $userRoles = $user->roles->pluck('name')->toArray(); @endphp
                                @foreach ($userRoles as $userRole)
                                    <span class="px-2 py-0.5 text-xs rounded-full
                                        {{ $userRole === 'admin' ? 'bg-violet-100 text-violet-700 border border-violet-200' : '' }}
                                        {{ $userRole === 'lider' ? 'bg-rose-100 text-rose-700 border border-rose-200' : '' }}
                                        {{ $userRole === 'colaborador' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                        {{ $userRole === 'invitado' ? 'bg-slate-50 text-slate-600 border border-slate-200' : '' }}">
                                        {{ ucfirst($userRole) }}
                                    </span>
                                @endforeach
                                @if (empty($userRoles))
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.users.assignRole', $user) }}"
                                      method="POST" class="flex gap-2 items-center">
                                    @csrf
                                    <select name="role"
                                            class="bg-rose-50 border border-rose-100 text-slate-700 rounded-xl px-3 py-1.5 text-xs
                                            focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200 transition-all">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                    @selected($user->hasRole($role->name))>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white text-xs rounded-2xl transition-all shadow-sm shadow-rose-500/25">
                                        Asignar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t border-rose-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>