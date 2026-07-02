<x-app-layout>
    <x-slot name="header">
        <h1 class="text-white font-semibold text-lg">Administración de usuarios</h1>
    </x-slot>

    <div class="p-6">
        <div class="bg-[#161B22] border border-white/10 rounded-xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#0D1117] border-b border-white/10">
                    <tr>
                        <th class="py-3 px-4 text-gray-400 text-xs font-medium uppercase tracking-wider">Usuario</th>
                        <th class="py-3 px-4 text-gray-400 text-xs font-medium uppercase tracking-wider">Email</th>
                        <th class="py-3 px-4 text-gray-400 text-xs font-medium uppercase tracking-wider">Rol actual</th>
                        <th class="py-3 px-4 text-gray-400 text-xs font-medium uppercase tracking-wider">Cambiar rol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-gray-300 text-sm">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-400 text-sm">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @php $userRoles = $user->roles->pluck('name')->toArray(); @endphp
                                @foreach ($userRoles as $userRole)
                                    <span class="px-2 py-0.5 text-xs rounded-full
                                        {{ $userRole === 'admin' ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20' : '' }}
                                        {{ $userRole === 'lider' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}
                                        {{ $userRole === 'colaborador' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : '' }}
                                        {{ $userRole === 'invitado' ? 'bg-gray-500/10 text-gray-400 border border-gray-500/20' : '' }}">
                                        {{ ucfirst($userRole) }}
                                    </span>
                                @endforeach
                                @if (empty($userRoles))
                                    <span class="text-gray-500 text-xs">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.users.assignRole', $user) }}"
                                    method="POST" class="flex gap-2">
                                    @csrf
                                    <select name="role"
                                        class="bg-[#0D1117] border border-white/10 text-white rounded-lg px-3 py-1.5 text-xs
                                        focus:outline-none focus:border-blue-500 transition-all">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                @selected($user->hasRole($role->name))>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs rounded-lg transition-all">
                                        Asignar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t border-white/10">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>