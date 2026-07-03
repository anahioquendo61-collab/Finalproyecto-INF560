<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Acceso denegado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-rose-50 via-pink-50 to-violet-50 min-h-screen flex items-center justify-center">
    <div class="text-center p-8 bg-white/90 border border-rose-100 rounded-2xl shadow-lg max-w-md backdrop-blur-sm">
        <div class="text-6xl mb-4">🔒</div>
        <h3 class="text-xl font-semibold text-rose-700 mb-2">
            Acceso denegado
        </h3>
        <p class="text-slate-500 mb-6 text-sm">
            No tienes permiso para acceder a esta sección.
        </p>
        <a href="{{ url('/dashboard') }}"
           class="inline-block px-5 py-2 bg-gradient-to-r from-rose-500 via-pink-500 to-violet-500 hover:from-rose-500 hover:via-pink-600 hover:to-violet-500 text-white rounded-2xl font-medium text-sm transition-all shadow-md shadow-rose-500/25">
            Volver al inicio
        </a>
    </div>
</body>
</html>