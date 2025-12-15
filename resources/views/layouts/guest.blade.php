<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Culture Bénin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Background video for auth pages -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <video autoplay muted loop playsinline class="w-full h-full object-cover">
            <source src="{{ asset('videos/arriere_hero.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- slight dark overlay for readability -->
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center relative z-10">
        <div class="max-w-2xl w-full p-6">
            <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow p-8">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>