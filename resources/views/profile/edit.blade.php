<x-app-layout>
    <x-slot name="header">
        <h1 class="text-rose-700 font-semibold text-lg">
            Perfil
        </h1>
    </x-slot>

    <div class="p-6 max-w-2xl space-y-6">

        <div class="bg-white border border-rose-100 rounded-2xl p-6 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white border border-rose-100 rounded-2xl p-6 shadow-sm">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white border border-rose-100 rounded-2xl p-6 shadow-sm">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>