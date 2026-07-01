<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Página no encontrada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0D1117] min-h-screen flex items-center justify-center">
    <div class="text-center p-8 bg-[#161B22] border border-white/10 rounded-2xl shadow-xl max-w-md">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-semibold text-white mb-2">Página no encontrada</h3>
        <p class="text-gray-400 mb-6 text-sm">La URL que buscas no existe o fue eliminada.</p>
        <a href="{{ url('/') }}"
            class="inline-block px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-medium text-sm transition-all">
            Volver al inicio
        </a>
    </div>
</body>
</html>