<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'KMS PNC') }} - Knowledge Management System</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12"
             style="background: linear-gradient(135deg, #0a3a55 0%, #0e4b6d 50%, #0a3a55 100%);">

            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="p-2 rounded-2xl shadow-2xl bg-white/10 backdrop-blur-sm">
                        <img src="{{ asset('https://pnc.ac.id/wp-content/uploads/2020/03/Logo-PNC.png') }}"
                             alt="Logo PNC"
                             class="h-20 w-20 object-contain rounded-xl bg-white p-1">
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white tracking-wide">Politeknik Negeri Cilacap</h1>
                <p class="text-sm font-medium mt-1 text-campus-orange">Knowledge Management System</p>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md rounded-2xl overflow-hidden shadow-2xl bg-white">
                <div class="h-1 bg-campus-orange"></div>
                <div class="px-8 py-7">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-6 text-xs text-white/40">&copy; {{ date('Y') }} Politeknik Negeri Cilacap</p>
        </div>
    </body>
</html>
