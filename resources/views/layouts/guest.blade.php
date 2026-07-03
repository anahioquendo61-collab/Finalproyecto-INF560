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
<body class="font-sans antialiased bg-gradient-to-br from-rose-50 via-pink-50 to-violet-50">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        {{-- Logo --}}
        <div class="flex flex-col items-center mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-rose-500 via-pink-500 to-violet-500 rounded-xl flex items-center justify-center shadow-2xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7 text-white"
                     viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M4 4h7v9H4zM13 4h7v5h-7zM13 13h7v7h-7zM4 17h7v3H4z"/>
                </svg>
            </div>
            <h1 class="text-rose-700 font-bold text-3xl tracking-wide">
                Gestor Jira
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Gestión de proyectos colaborativos
            </p>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md bg-white/90 border border-rose-100 rounded-2xl shadow-2xl p-8 backdrop-blur-sm">
            {{ $slot }}
        </div>

        <p class="text-slate-400 text-xs mt-6">
            INF560 · UATF · 2026
        </p>
    </div>
</body>
</html>