<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=bebas-neue:400|instrument-sans:400,500,600&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <video playsinline autoplay muted loop poster="/images/fallback-background.jpg"
            class="object-cover w-full h-full">
            <source src="/videos/background-video.mp4" type="video/mp4">
        </video>
        <div class="absolute top-0 left-0 w-full h-full bg-black/60"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gray-900/50 backdrop-blur-lg shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
