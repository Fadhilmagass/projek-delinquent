<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'delinquent.id') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div x-data="{ atTop: true }" @scroll.window="atTop = (window.pageYOffset > 50) ? false : true" class="min-h-screen">

        <header
            :class="{ 'bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-md': !atTop, 'bg-transparent': atTop }"
            class="fixed w-full z-50 transition-all duration-300 ease-in-out">
            @include('layouts.navigation')
        </header>

        <div class="pt-20">
            @if (isset($header))
                <div class="bg-white dark:bg-gray-800 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endif

            <main class="my-8">
                {{ $slot }}
            </main>
        </div>

        @include('layouts.partials.footer')
    </div>
</body>

</html>
