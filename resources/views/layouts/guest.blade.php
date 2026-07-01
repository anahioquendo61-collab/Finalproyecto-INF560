<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Trello') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0D1117]">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        {{-- Logo --}}
        <div class="flex flex-col items-center mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center shadow-2xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 4h7v9H4zM13 4h7v5h-7zM13 13h7v7h-7zM4 17h7v3H4z"/>
                </svg>
            </div>
            <h1 class="text-white font-bold text-3xl tracking-wide">Trello</h1>
            <p class="text-gray-500 text-sm mt-1">Gestión de proyectos colaborativos</p>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md bg-[#161B22] border border-white/10 rounded-2xl shadow-2xl p-8">
            {{ $slot }}
        </div>

        <p class="text-gray-600 text-xs mt-6">INF560 · UATF · 2026</p>
    </div>
</body>
</html>