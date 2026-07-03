<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestor Jira') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-rose-50 text-slate-800">
<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 min-h-screen bg-white/90 border-r border-rose-100 flex flex-col fixed top-0 left-0 z-50 shadow-md backdrop-blur-sm">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-rose-100 bg-gradient-to-r from-rose-50 via-pink-50 to-violet-50">
            <div class="w-9 h-9 bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 rounded-2xl flex items-center justify-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 4h7v9H4zM13 4h7v5h-7zM13 13h7v7h-7zM4 17h7v3H4z"/>
                </svg>
            </div>
            <span class="text-rose-700 font-semibold text-lg tracking-wide">
                GestorPro
            </span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

            <p class="text-[11px] text-rose-400 uppercase tracking-[0.18em] px-3 mb-2">
                Principal
            </p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('dashboard') ? 'bg-rose-100 text-rose-700 border border-rose-200 shadow-sm' : 'text-slate-500 hover:bg-rose-50 hover:text-rose-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Inicio
            </a>

            <a href="{{ route('projects.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('projects.*') ? 'bg-rose-100 text-rose-700 border border-rose-200 shadow-sm' : 'text-slate-500 hover:bg-rose-50 hover:text-rose-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Tableros
            </a>

            @role('admin')
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-150
               {{ request()->routeIs('admin.*') ? 'bg-rose-100 text-rose-700 border border-rose-200 shadow-sm' : 'text-slate-500 hover:bg-rose-50 hover:text-rose-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Usuarios
            </a>
            @endrole

            {{-- Mis tableros recientes --}}
            <div class="pt-4">
                <p class="text-[11px] text-rose-400 uppercase tracking-[0.18em] px-3 mb-2">
                    Mis tableros
                </p>
                @auth
                @foreach(auth()->user()->allProjects()->latest()->take(5)->get() as $p)
                    <a href="{{ route('projects.show', $p) }}"
                       class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs text-slate-500 hover:bg-rose-50 hover:text-rose-700 transition-all duration-150 truncate">
                        <span class="w-3 h-3 rounded-full flex-shrink-0 border border-rose-100"
                              style="background-color: {{ $p->color }}"></span>
                        <span class="truncate">{{ $p->nombre }}</span>
                    </a>
                @endforeach
                @endauth
            </div>

        </nav>

        {{-- Usuario --}}
        <div class="px-3 py-3 border-t border-rose-100 bg-gradient-to-r from-rose-50 via-pink-50 to-violet-50">
            <div class="flex items-center gap-3 px-3 py-2 mb-2 rounded-2xl bg-white/70 shadow-sm">
                <div class="w-9 h-9 bg-gradient-to-br from-rose-400 via-pink-500 to-violet-500 rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-700 text-xs font-medium truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-slate-400 text-xs truncate">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs text-rose-600 hover:bg-rose-100 hover:text-rose-700 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs text-rose-500 hover:bg-rose-100 hover:text-rose-700 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENIDO --}}
    <div class="flex-1 ml-64 flex flex-col min-h-screen">

        {{-- Topbar --}}
        <header class="h-16 bg-white/80 border-b border-rose-100 flex items-center px-6 gap-4 sticky top-0 z-40 backdrop-blur-sm">
            @isset($header)
                <div class="flex-1 text-sm font-medium text-slate-700">
                    {{ $header }}
                </div>
            @endisset
        </header>

        {{-- Flash --}}
        @if (session('success'))
            <div class="mx-6 mt-4 p-3 bg-pink-50 text-pink-700 border border-pink-100 rounded-2xl text-sm flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 mt-4 p-3 bg-rose-50 text-rose-600 border border-rose-100 rounded-2xl text-sm flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Contenido --}}
        <main class="flex-1 px-6 py-6 bg-gradient-to-br from-rose-50 via-pink-50 to-violet-50">
            {{ $slot }}
        </main>
    </div>

</div>
</body>
</html>