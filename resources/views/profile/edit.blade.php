<x-app-layout>
    <x-slot name="header">
        <h1 class="text-white font-semibold text-lg">Perfil</h1>
    </x-slot>

    <div class="p-6 max-w-2xl space-y-6">

        <div class="bg-[#161B22] border border-white/10 rounded-xl p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-[#161B22] border border-white/10 rounded-xl p-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-[#161B22] border border-white/10 rounded-xl p-6">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>