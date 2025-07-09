<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'delinquent.id') }}</title>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        @include('layouts.navigation')

        {{-- Main Content --}}
        <main class="flex-grow">
            {{-- Optional Header Section --}}
            @isset($header)
                <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            {{-- Slot Content --}}
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </div>
        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')
    </div>

    {{-- Livewire Scripts --}}
    @livewireScripts
    @stack('scripts')
</body>

</html>
