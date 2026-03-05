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
    <body class="font-sans antialiased bg-gray-100 text-campus-dark">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white border-b border-campus-gray/40 shadow-sm">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                {{ $slot }}
            </main>

            <footer class="mt-auto py-4 border-t border-campus-gray/30 text-center text-xs text-gray-400 bg-white">
                &copy; {{ date('Y') }} Politeknik Negeri Cilacap &mdash; Knowledge Management System
            </footer>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-alert]').forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-8px)';
                    setTimeout(function () { el.remove(); }, 500);
                }, 4000);
            });
        });
        </script>
    </body>
</html>
