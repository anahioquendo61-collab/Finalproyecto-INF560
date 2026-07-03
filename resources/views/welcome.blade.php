<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Gestor Jira') }}</title>

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* ... (bloque de estilos fallback original, sin modificar) ... */
            </style>
        @endif
    </head>
    <body class="antialiased bg-gradient-to-b from-rose-50/40 via-slate-50 to-white text-slate-700 min-h-screen flex flex-col">

        {{-- HEADER --}}
        <header class="w-full">
            <div class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
                {{-- Marca --}}
                <div class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-violet-500 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="7" height="16" rx="2"/>
                            <rect x="14" y="4" width="7" height="9" rx="2"/>
                        </svg>
                    </span>
                    <span class="text-lg font-semibold tracking-tight text-slate-800">Gestor Jira</span>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center px-5 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium shadow-sm transition">
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-rose-600 transition">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-5 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium shadow-sm transition">
                                    Crear cuenta
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        {{-- HERO --}}
        <main class="flex-1 flex items-center">
            <div class="max-w-6xl mx-auto px-6 py-12 w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Columna de texto --}}
                <div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-100 text-rose-600 text-xs font-medium tracking-wide uppercase mb-5">
                        Gestión visual de proyectos
                    </span>

                    <h1 class="text-4xl lg:text-5xl font-semibold text-slate-800 leading-tight mb-4">
                        Organiza tus proyectos
                        <span class="bg-gradient-to-r from-rose-500 to-violet-500 bg-clip-text text-transparent">con estilo y claridad</span>
                    </h1>

                    <p class="text-slate-500 text-base leading-relaxed mb-8 max-w-md">
                        Gestor Jira te ayuda a planificar, priorizar y dar seguimiento a tus tareas en tableros
                        limpios y colaborativos, inspirados en las mejores herramientas de gestión visual.
                    </p>

                    @if (Route::has('login'))
                        @guest
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium shadow-sm transition">
                                    Comenzar gratis
                                </a>
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 text-sm font-medium shadow-sm transition">
                                    Ya tengo cuenta
                                </a>
                            </div>
                        @else
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium shadow-sm transition">
                                Ir a mis tableros
                            </a>
                        @endguest
                    @endif

                    <p class="mt-8 text-xs text-slate-400">
                        Proyecto académico — INF560 · UATF · v{{ app()->version() }}
                    </p>
                </div>

                {{-- Columna visual: mini preview de tablero --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-br from-rose-100 via-pink-50 to-violet-100 rounded-3xl blur-2xl opacity-70"></div>

                    <div class="relative bg-white border border-rose-100 rounded-2xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-sm font-semibold text-slate-700">Proyecto: Rediseño Web</span>
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span class="text-xs text-slate-400">Activo</span>
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-xs font-medium text-slate-500 mb-3">Por hacer</p>
                                <div class="space-y-2">
                                    <div class="bg-white rounded-lg border border-rose-100 shadow-sm px-3 py-2 text-xs text-slate-600">Diseñar mockups</div>
                                    <div class="bg-white rounded-lg border border-rose-100 shadow-sm px-3 py-2 text-xs text-slate-600">Definir paleta</div>
                                </div>
                            </div>

                            <div class="bg-rose-50/60 rounded-xl p-3">
                                <p class="text-xs font-medium text-rose-500 mb-3">En proceso</p>
                                <div class="space-y-2">
                                    <div class="bg-white rounded-lg border border-rose-100 shadow-sm px-3 py-2 text-xs text-slate-600">Maquetar tablero</div>
                                </div>
                            </div>

                            <div class="bg-violet-50/60 rounded-xl p-3">
                                <p class="text-xs font-medium text-violet-500 mb-3">Hecho</p>
                                <div class="space-y-2">
                                    <div class="bg-white rounded-lg border border-rose-100 shadow-sm px-3 py-2 text-xs text-slate-600 line-through decoration-rose-300">Investigación</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        {{-- FOOTER simple --}}
        <footer class="w-full py-6">
            <p class="text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Gestor Jira — Hecho con Laravel {{ app()->version() }}
            </p>
        </footer>
    </body>
</html>